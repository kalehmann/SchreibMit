<?php

namespace App\Controller;

use App\Document\UserDocument;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @\Symfony\Component\Routing\Annotation\Route("/", name="home", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function homeAction(Request $request): Response
    {
        $userDocument = new UserDocument();

        $userForm = $this->createForm(UserType::class, $userDocument);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            var_dump($userForm->getData());
        }

        return $this->render(
            'home.html.twig',
            [
                'userForm' => $userForm->createView(),
            ]
        );
    }

    protected function createUser(UserDocument $userDocument): void
    {
        
    }
}