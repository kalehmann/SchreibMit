<?php


namespace DrkDD\Pflegefinder\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package DrkDD\Pflegefinder\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/logout", name="backend_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}