<?php

namespace DrkDD\Pflegefinder\Controller;

use DrkDD\Pflegefinder\Document\UserDocument;
use DrkDD\Pflegefinder\Entity\Pflegeheim;
use DrkDD\Pflegefinder\Entity\PostalCode;
use DrkDD\Pflegefinder\Entity\User;
use DrkDD\Pflegefinder\Form\Type\UserType;
use DrkDD\Pflegefinder\Repository\PflegeHeimRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer)
    {
        $this->entityManager = $em;
        $this->mailer = $mailer;
    }

    /**
     * @\Symfony\Component\Routing\Annotation\Route("/", name="home", methods={"GET", "POST"})
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
     * @param UserDocument $userDocument
     * @return bool
     */
    protected function addUser(UserDocument $userDocument): bool
    {
        $pflegeheimRepo = $this->entityManager->getRepository(Pflegeheim::class);
        $userRepo = $this->entityManager->getRepository(User::class);

        if ($userRepo->findOneBy(['email' => $userDocument->email])) {
            $this->addFlash('notice', 'Du hast mit dieser E-mail Adresse bereits teilgenommen');

            return false;
        }

        $user = $this->mapUserDocumentToUser($userDocument);
        $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());
        $pflegeheim = $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());

        if (!$pflegeheim) {
            $this->addFlash('notice', 'Wir haben leider kein Pflegeheim in deiner Nähe gefunden, bitte probiere es später nocheinmal');

            return false;
        }
        $user->setPflegeheim($pflegeheim);

        $this->sendContactMessage($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $this->addFlash('notice', 'Danke für deine Teilnahme, wir haben dir eine E-Mail mit weiteren Infos geschickt.');


        return true;
    }

    /**
     * @param User $user
     */
    protected function sendContactMessage(User $user): void
    {
        $message = (new \Swift_Message('Schreib mit!'))
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