<?php

namespace App\Tests;

use App\Entity\User;
use FactoryGirl\Provider\Doctrine\FixtureFactory as BaseFixtureFactory;

class RegisterControllerTest extends DatabaseWebTestCase
{
    private $admin;

    protected function setUpFixtures(BaseFixtureFactory $factory)
    {
        $this->admin = $factory->get(User::class, [
            'username' => 'vagrant',
            'password' => 'vagrant',
            'roles' => ['ROLE_ADMIN'],
        ]);
    }

    public function testUnAuthenticatedUsersShouldBeAbleToAccessRegisterPage()
    {
        $client = $this->createClient();

        $client->request('GET', '/register');

        $this->assertContains('Register', $client->getResponse()->getContent());
    }

    public function testUnAuthenticatedUsersShouldBeAbleToRegister()
    {
        $client = $this->createClient();
        $client->request(
            'POST',
            '/register',
            [
                'register' => [
                    'username' => 'user_test',
                    'plainPassword' => [
                        'first' => '123qwe',
                        'second' => '123qwe',
                    ],
                    'name' => 'user',
                    'email' => 'test@gmail.com',
                    'phone' => '0888888888',
                    'termsAccepted' => true
                ],
            ]
        );
        $client->followRedirect();

        $this->assertContains('Registered successfully!', $client->getResponse()->getContent());
    }

    public function testAuthenticatedUsersShouldNotBeAbleToAccessRegisterPage()
    {
        $client = $this->createClient();
        $client->login($this->admin);

        $client->request('GET', '/register');
        $client->followRedirect();

        $this->assertContains('Welcome!', $client->getResponse()->getContent());
    }

    public function testRegisterWithAlreadyUsedEmail()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/register');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $form = $crawler->filter('form[name=register]')->form();

        $client->submit($form, [
            'register' => [
                'email' => $this->admin->getEmail(),
                'plainPassword' => ['first' => '123qwe', 'second' => '123qwe'],
                'username' => 'testuser',
                'name' => 'test',
                'termsAccepted' => true
            ],
        ]);
        $client->followRedirect();

        $this->assertContains('Username or email already used', $client->getResponse()->getContent());
    }

    public function testRegisterWithAlreadyUsedUsername()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/register');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $form = $crawler->filter('form[name=register]')->form();

        $client->submit($form, [
            'register' => [
                'email' => 'testt@mail.com',
                'plainPassword' => ['first' => '123qwe', 'second' => '123qwe'],
                'username' => $this->admin->getUsername(),
                'name' => 'test',
                'termsAccepted' => true
            ],
        ]);
        $client->followRedirect();

        $this->assertContains('Username or email already used', $client->getResponse()->getContent());
    }
}
