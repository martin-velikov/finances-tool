<?php

namespace App\Controller\User;

use App\Form\Type\UserProfileType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class EditUserController extends AbstractController
{
    /**
     * @App\Route("/profile/edit", name="edit_user_profile", methods="GET|POST")
     */
    public function __invoke(
        Request $request,
        ObjectManager $objectManager
    ): Response
    {
        $form = $this->createForm(UserProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->flush();
            $this->addFlash('notice', 'Profile edited successfully!');

            return $this->redirectToRoute('show_user_profile');
        }

        return $this->render('User/profile_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
