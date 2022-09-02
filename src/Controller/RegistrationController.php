<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Services\Mailer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, 
    UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, SluggerInterface $slugger, Mailer $mailer, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $this->mailer = $mailer;

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setToken($this->generateToken());
            $setPhoto = $form->get('photo')->getData();
            

            if ($setPhoto) {
                $originalFilename = pathinfo($setPhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setPhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setPhoto->move(
                        $this->getParameter('users_photo'),
                        $newFilename
                    );
                } catch (FileException $e){
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPhoto($newFilename);
                $entityManager->persist($user);
                $entityManager->flush();
            }
            
            $this->mailer->sendEmail($user->getEmail(), $user->getToken());

        }
        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
 
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(length: 32)), '+/', '-_'), '=');
    }

    #[Route('/confirm-account?token={token}', name: 'confirm_account')]
    public function confirmAccount($token, EntityManagerInterface $entityManager, UsersRepository $usersRepository)
    {
        $user = $usersRepository->findOneBy(['token'=> $token]);

        if($user) {
            $user->setToken("");
            $user->setvalidate(validate:true);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect('/');
            $this->addFlash('success', 'Inscription réussie, vous pouvez maintenant vous connecter');

        } else {

            return $this->redirect('/');
            $this->addFlash('error', "Ce compte n'existe pas ou a déjà été validé");

        }
        return $this->json($token);
    } 
}
