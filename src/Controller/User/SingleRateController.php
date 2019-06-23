<?php

namespace App\Controller\User;

use App\Entity\Rates;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleRateController extends AbstractController
{
    /**
     * @App\Route("/profile/rates/{id}", name="single_rate", methods="GET")
     */
    public function __invoke(Request $request, Rates $rates): Response
    {
        if (!$this->isUsersRate($rates)) {
            return $this->redirectToRoute('show_user_profile');
        }

        return $this->render('User/single_rate.html.twig', [
            'rates' => $rates,
        ]);
    }

    /**
     * @App\Route("/profile/rates/{id}", name="delete_rate", methods="POST")
     */
    public function deleteRate(Rates $rates): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($rates);
        $entityManager->flush();

        $this->addFlash('notice', "Successfully deleted rates.");

        return $this->redirectToRoute('show_user_profile');
    }

    private function isUsersRate(Rates $rates): bool
    {
        $userRates = $this->getUser()->getRates();

        foreach ($userRates as $rate) {
            if ($rate->getId() == $rates->getId()) {
                return true;
            }
        }

        return false;
    }
}
