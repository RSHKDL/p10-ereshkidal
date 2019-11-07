<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AboutController
 * @author ereshkidal
 */
class AboutController extends AbstractController
{
    /**
     * @Route("/about/resume", name="resume")
     */
    public function showResume()
    {
        return $this->render('about/resume.html.twig');
    }
}
