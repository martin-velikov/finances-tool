<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowRatesController extends AbstractController
{
    /**
     * @App\Route("/profile/rates", name="show_rates", methods="GET")
     */
    public function __invoke(Request $request): Response
    {
        return $this->render('User/profile_show.html.twig', [
            'userRates' => $this->getUser()->getRates(),
        ]);
    }
}
