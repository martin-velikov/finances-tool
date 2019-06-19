<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Tests\DatabaseWebTestCase;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

class ShowUserTest extends DatabaseWebTestCase
{
    private $user;

    protected function setUpFixtures(BaseFixtureFactory $factory)
    {
        $this->user = $factory->get(User::class);
    }

    public function testLoggedInUserShouldBeAbleToAccessProfilePage()
    {
        $client = $this->createClient();
        $client->login($this->user);
        $client->request('GET', '/profile');

        $this->assertContains('My profile', $client->getResponse()->getContent());
    }

    public function testNotLoggedInUserShouldNotBeAbleToAccessProfilePage()
    {
        $client = $this->createClient();
        $client->request('GET', '/profile');
        $client->followRedirect();

        $this->assertContains('login', $client->getResponse()->getContent());
    }
}
