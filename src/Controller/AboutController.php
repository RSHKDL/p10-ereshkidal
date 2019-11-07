<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AboutController
 * @author ereshkidal
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="app_about")
     */
    public function index(): Response
    {
        return $this->render('about/index.html.twig');
    }

    /**
     * @Route("/about/resume", name="app_resume")
     */
    public function showResume(): Response
    {
        return $this->render('about/resume.html.twig');
    }
}
