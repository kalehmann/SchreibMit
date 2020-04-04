<?php


namespace DrkDD\Pflegefinder\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LegalController
 * @package DrkDD\Pflegefinder\Controller
 */
class LegalController extends AbstractController
{
    /**
     * @Route("/impressum", name="legal_impressum")
     *
     * @return Response
     */
    public function impressumAction(): Response
    {
        return $this->render('legal/impressum.html.twig');
    }

    /**
     * @Route("/datenschutz", name="legal_gdpr")
     *
     * @return Response
     */
    public function gdprAction(): Response
    {
        return $this->render('legal/gdpr.html.twig');
    }
}