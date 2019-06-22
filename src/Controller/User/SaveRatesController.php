<?php

namespace App\Controller\User;

use App\Entity\Rates;
use App\OpenExchangeRateApi\OpenExchange;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveRatesController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @App\Route("/profile/save", name="save_rates", methods="GET|POST")
     */
    public function __invoke(Request $request, OpenExchange $openExchange): Response
    {
        if ($this->isTodayDate()) {
            $this->addFlash('notice', "You already saved today's exchange rates.");
        }

        if (!$this->isTodayDate()) {
            $rates = new Rates();
            $rates->setRates($openExchange->getRates());
            $user = $this->getUser()->addRates($rates);
            $this->entityManager->flush($user);

            $this->addFlash('notice', "Successfully saved today's exchange rates");
        }

        return $this->redirectToRoute('show_user_profile');
    }

    private function isTodayDate(): bool
    {
        $userRates = $this->getUser()->getRates();
        $date = new \DateTime();
        $date->setTime(0, 0);

        foreach ($userRates as $rate) {
            if ($rate->getCreatedAt() == $date) {
                return true;
            }
        }

        return false;
    }
}
