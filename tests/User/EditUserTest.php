<?php

namespace App\Tests\User;

use App\Entity\User;
use App\Tests\DatabaseWebTestCase;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

class EditUserTest extends DatabaseWebTestCase
{
    private $user;

    protected function setUpFixtures(BaseFixtureFactory $factory)
    {
        $this->user = $factory->get(User::class);
    }

    public function testUserShouldBeAbleToEditProfile()
    {
        $client = $this->createClient();
        $client->login($this->user);

        $crawler = $client->request('GET', '/profile/edit');
        $form = $crawler->filter('form[name=user_profile]')->form();

        $client->submit($form, [
            'user_profile' => [
                'name' => 'new name',
            ]
        ]);
        $client->followRedirect();

        $this->assertContains('Profile edited successfully!', $client->getResponse()->getContent());
    }

    public function testUnauthenticatedUserShouldNotBeAbleToEditProfile()
    {
        $client = $this->createClient();
        $client->request('GET', '/profile/edit');
        $client->followRedirect();

        $this->assertContains('login', $client->getResponse()->getContent());
    }
}
