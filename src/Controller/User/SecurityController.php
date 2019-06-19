<?php

namespace App\Controller\User;

use App\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @App\Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $form = $this->createForm(LoginType::class);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('User/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
