<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function logout(): Response
    {
        throw new \Exception('This should never be reached!');
    }

    #[Route('/profile/edit', name: 'app_edit_username')]
    public function editUsername(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile/edit_username.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/change-password', name: 'app_change_password', methods: ['POST'])]
    public function changePassword(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {

        $user = $this->getUser();
    
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
    
        $oldPassword = $request->request->get('old_password');

        $newPassword = $request->request->get('new_password');
        $confirmPassword = $request->request->get('confirm_password');
    
        if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
            $this->addFlash('danger', 'Old password Incorrect.');
            return $this->redirectToRoute('app_profile');
        }
    
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('danger', 'New password and confirm password do not match.');
            return $this->redirectToRoute('app_profile');
        }
    
        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);
        $entityManager->persist($user);
        $entityManager->flush();
    
        $security->logout(false);
        $this->addFlash('success', 'Password changed successfully. Please login with new password.');
        
        return $this->redirectToRoute('app_login');
    }

}
