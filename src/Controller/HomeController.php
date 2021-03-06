<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Controller;

use DrkDD\SchreibMit\Document\UserDocument;
use DrkDD\SchreibMit\Entity\Pflegeheim;
use DrkDD\SchreibMit\Entity\PostalCode;
use DrkDD\SchreibMit\Entity\User;
use DrkDD\SchreibMit\Form\Type\UserType;
use DrkDD\SchreibMit\Repository\PflegeHeimRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HomeController
 * @package DrkDD\SchreibMit\Controller
 */
class HomeController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var \Swift_Mailer */
    protected $mailer;

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * HomeController constructor.
     * @param EntityManagerInterface $em
     * @param \Swift_Mailer          $mailer
     * @param TranslatorInterface    $translator
     */
    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer, TranslatorInterface $translator)
    {
        $this->entityManager = $em;
        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function homeAction(Request $request): Response
    {
        /** @var PflegeHeimRepository $pflegeheimRepo */
        $userDocument = new UserDocument();

        $userForm = $this->createForm(UserType::class, $userDocument);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $userDocument = $userForm->getData();
            if ($this->addUser($userDocument)) {
                // Formular zurücksetzen
                $userForm = $this->createForm(UserType::class, new UserDocument());
            }
        }

        return $this->render(
            'home.html.twig',
            [
                'userForm' => $userForm->createView(),
            ]
        );
    }

    /**
     * Erstellt aus einem UserDocument einen neuen Nutzer, weist ihm ein Pflegeheim zu und
     * informiert ihn per E-Mail über die Zuweisung.
     *
     * Im Fehlerfall wird false zurúckgegeben und eine FlashMessage mit der Fehlerbeschreibung angelegt.
     *
     * @param UserDocument $userDocument
     * @return bool
     */
    protected function addUser(UserDocument $userDocument): bool
    {
        $pflegeheimRepo = $this->entityManager->getRepository(Pflegeheim::class);
        $userRepo = $this->entityManager->getRepository(User::class);

        if ($userRepo->findOneBy(['email' => $userDocument->email])) {
            $this->addFlash('notice', $this->translator->trans('flash_message.double_participation'));

            return false;
        }

        $user = $this->mapUserDocumentToUser($userDocument);
        $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());
        $pflegeheim = $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());

        if (!$pflegeheim) {
            $this->addFlash('notice', $this->translator->trans('flash_message.not_found'));

            return false;
        }
        $user->setPflegeheim($pflegeheim);

        $this->sendContactMessage($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->addFlash('notice', $this->translator->trans('flash_message.successful_participation'));

        return true;
    }

    /**
     * Sendet die E-Mail, welche den Nutzer über das ihm zugewiesene Pflegeheim informiert.
     *
     * @param User $user
     */
    protected function sendContactMessage(User $user): void
    {
        $message = (new \Swift_Message($this->translator->trans('email.subject')))
            ->setFrom(
                $this->getParameter('senderMail')
            )
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'email/contact.html.twig',
                    ['user' => $user]
                ),
                'text/html'
            )
            ->addPart(
                $this->renderView(
                    'email/contact.txt.twig',
                    ['user' => $user]
                ),
                'text/plain'
            );

        $this->mailer->send($message);
    }

    /**
     * Mappt die Daten aus einem UserDocument auf die Entiät User
     *
     * @param UserDocument $document
     * @return User
     */
    protected function mapUserDocumentToUser(UserDocument $document): User
    {
        $postalCodeRepo = $this->entityManager->getRepository(PostalCode::class);

        $user = new User();
        $user->setName($document->name);
        $user->setEmail($document->email);
        $user->setAge($document->age);

        /** @var PostalCode $postalCode */
        $postalCode = $postalCodeRepo->find($document->postalCode);
        $user->setPostalCode($postalCode);

        return $user;
    }
}