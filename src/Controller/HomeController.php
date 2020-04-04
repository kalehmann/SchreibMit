<?php

namespace App\Controller;

use App\Document\UserDocument;
use App\Entity\Pflegeheim;
use App\Entity\PostalCode;
use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\PflegeHeimRepository;
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
        $pflegeheimRepo = $this->entityManager->getRepository(Pflegeheim::class);
        $userDocument = new UserDocument();

        $userForm = $this->createForm(UserType::class, $userDocument);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $userDocument = $userForm->getData();
            $user = $this->mapUserDocumentToUser($userDocument);
            $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());
            $pflegeheim = $pflegeheimRepo->findNearestForPostalCode($user->getPostalCode());

            if ($pflegeheim) {
                $user->setRegistrationDate(new \DateTimeImmutable());
                $user->setPflegeheim($pflegeheim);

                $this->sendContactMessage($user);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        }

        return $this->render(
            'home.html.twig',
            [
                'userForm' => $userForm->createView(),
            ]
        );
    }

    protected function sendContactMessage(User $user): void
    {
        $message = (new \Swift_Message('JRK Pflegefinder'))
            ->setFrom('mail@jrksachsen.de')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'email/contact.html.twig',
                    ['user' => $user]
                ),
                'text/html'
            )
        ->addPart(
            $this->renderView(
            // templates/emails/registration.html.twig
                'email/contact.txt.twig',
                ['user' => $user]
            ),
            'text/plain'
        );

        $this->mailer->send($message);
    }

    protected function mapUserDocumentToUser(UserDocument $document): User
    {
        $postalCodeRepo = $this->entityManager->getRepository(PostalCode::class);

        $user = new User();
        $user->setName($document->name);
        $user->setEmail($document->email);
        $user->setAge($document->age);

        $postalCode = $postalCodeRepo->find($document->postalCode);
        $user->setPostalCode($postalCode);

        return $user;
    }
}