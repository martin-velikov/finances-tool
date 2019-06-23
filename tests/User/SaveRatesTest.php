<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Tests\DatabaseWebTestCase;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

class SaveRatesTest extends DatabaseWebTestCase
{
    private $user;

    protected function setUpFixtures(BaseFixtureFactory $factory)
    {
        $this->user = $factory->get(User::class);
    }

    public function testUserShouldBeAbleToSaveTodayRates()
    {
        $client = $this->createClient();
        $client->login($this->user);

        $client->request('POST', '/profile/save');
        $client->followRedirect();

        // &#039; is the code for apostrophe
        $this->assertContains("Successfully saved today&#039;s exchange rates", $client->getResponse()->getContent());
    }

    public function testUserShouldNotBeAbleToSaveTwiceOnTheSameDay()
    {
        $client = $this->createClient();
        $client->login($this->user);

        $client->request('POST', '/profile/save');
        $client->followRedirect();
        // make second request to see if it's going to save again
        $client->request('POST', '/profile/save');
        $client->followRedirect();

        $this->assertContains("You already saved today&#039;s exchange rates.", $client->getResponse()->getContent());
    }
}
