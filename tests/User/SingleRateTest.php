<?php

namespace App\Tests\User;

use App\Entity\Rates;
use App\Entity\User;
use App\Tests\DatabaseWebTestCase;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

class SingleRateTest extends DatabaseWebTestCase
{
    private $user;

    protected function setUpFixtures(BaseFixtureFactory $factory)
    {
        $this->user = $factory->get(User::class);
        $rate = $factory->get(Rates::class);
        $this->user->addRates($rate);
        $this->getManager()->flush($this->user);
    }

    public function testUserShouldBeAbleToAccessHisSavedRates()
    {
        $client = $this->createClient();
        $client->login($this->user);
        $client->request('GET', '/profile/rates/2');
        //if you can access this page it means you have a saved rate so the date doesn't matter
        $this->assertContains("'s rate", $client->getResponse()->getContent());
    }

    public function testUserShoudNotBeAbleToAccessRandomRate()
    {
        $client = $this->createClient();
        $client->login($this->user);

        $client->request('GET', '/profile/rates/999');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}
