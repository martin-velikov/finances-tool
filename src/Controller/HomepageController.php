<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomepageController extends AbstractController
{
    /**
     * @App\Route("/", name="homepage")
     */
    public function __invoke(): Response {
        return $this->render('Homepage/index.html.twig');
    }
}
