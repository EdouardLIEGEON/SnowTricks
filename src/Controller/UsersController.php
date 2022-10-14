<?php

namespace App\Controller;
use App\Repository\UsersRepository;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Services\Mailer_resetPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/users')]
class UsersController extends AbstractController
{
    #[Route('/forgotPassword', name: 'forgotPassword')]
    public function forgotPassword(Request $request, UsersRepository $usersRepository, TokenGeneratorInterface $tokenGen, EntityManagerInterface $entityManager,
    Mailer_resetPassword $mailer_reset): Response
    {
        
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        $this->mailer_reset = $mailer_reset;

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            if($user){
                //On génère un token 
                $token = $tokenGen->generateToken();
                $user->setToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->mailer_reset->sendEmail($user->getEmail(), $user->getToken());

            }
            $this->addFlash('danger', 'un problème est survenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('/users/forgotPassword.html.twig', ['ForgotPassword' => $form->createView()]);
    }

    #[Route('/reset_password/{token}', name: 'reset_password')]
    public function resetPassword(ManagerRegistry $doctrine, $token, EntityManagerInterface $entityManager, 
    Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        

        $user = $usersRepository->findOneBy(['token'=> $token]);

        if ($user) {
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // On efface le token
                $user->setToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                    );
                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash('success', 'Mot de passe changé avec succès');
                    return $this->redirectToRoute('app_login');
            }
            return $this->render('/users/resetPassword.html.twig', ['ResetPassword' => $form->createView()]);

    }

    }
}