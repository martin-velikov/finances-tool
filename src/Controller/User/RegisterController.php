<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\Type\RegisterType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @App\Route("/register", name="register", methods="GET|POST")
     */
    public function __invoke(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        ObjectManager $objectManager,
        UserRepository $repository
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($repository->findOneBy(['username' => $user->getUsername()]) != null ||
            $repository->findOneBy(['email' => $user->getEmail()]) != null) {
            $this->addFlash('notice', 'Username or email already used');

            return $this->redirectToRoute('register');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $objectManager->persist($user);
            $objectManager->flush();

            $this->addFlash('notice', 'Registered successfully!');

            return $this->redirectToRoute('login');
        }

        return $this->render('User/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
