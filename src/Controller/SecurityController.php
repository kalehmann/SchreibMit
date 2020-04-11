<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityController
 * @package DrkDD\SchreibMit\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/logout", name="backend_logout", methods={"GET"})
     */
    public function logout(): void
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}