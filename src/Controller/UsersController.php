<?php

namespace App\Controller;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/users', name: 'users_')]
class UsersController extends AbstractController
{
    #[Route('/forgotPassword', name: 'forgotPassword')]
    public function forgotPassword(ManagerRegistry $doctrine, Request $request, UsersRepository $usersRepository): Response
    {
        
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $setEmail = $form->get('email')->getData();

            $users = $usersRepository->findBy(['email']);

        }

        return $this->render('/users/forgotPassword.html.twig', ['ForgotPassword' => $form->createView()]);
    }

    #[Route('/resetPassword', name: 'resetPassword')]
    public function resetPassword(ManagerRegistry $doctrine, Request $request, UsersRepository $usersRepository): Response
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        return $this->render('/users/resetPassword.html.twig', ['ResetPassword' => $form->createView()]);
    }
}