<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

class Client extends BaseClient
{
    public function login(UserInterface $user = null, $firewall = 'main')
    {
        $session = $this->getContainer()->get('session');
        $token = new UsernamePasswordToken(
            $user,
            '',
            $firewall,
            $user->getRoles()
        );
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->getCookieJar()->set($cookie);
    }
}
