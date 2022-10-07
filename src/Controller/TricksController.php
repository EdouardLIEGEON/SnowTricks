<?php

namespace App\Controller;
use App\Entity\Tricks;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CreateTrickType;
use App\Form\UpdateHeaderType;
use App\Form\UpdatePhotoType;
use App\Form\UpdateVideoType;
use App\Form\UpdateTrickType;
use App\Form\AddCommentType;
use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/tricks')]
class TricksController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TricksRepository $tricksRepository): Response
    {
        return $this->render('tricks/index.html.twig', 
            ['tricks' => $tricksRepository->findAll()]);
    }
    
    #[Route('/create', name:'create')]
    public function create(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        $tricks = new Tricks();
        $form = $this->createForm(CreateTrickType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $setName = $form->get('name')->getData();
            $setDescription = $form->get('description')->getData();
            $setType = $form->get('type')->getData();
            $setPhoto = $form->get('photo')->getData();
            $setVideo = $form->get('video')->getData();
            $setHeader = $form->get('header')->getData();


            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($setPhoto) {
                $originalFilename = pathinfo($setPhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setPhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setPhoto->move(
                        $this->getParameter('tricks_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setPhoto($newFilename);
            }
            if ($setHeader) {
                $originalFilename = pathinfo($setHeader->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setHeader->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setHeader->move(
                        $this->getParameter('UpdateTrick_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setHeader($newFilename);
            }
            $tricks->created_at = new DateTime();
            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('/tricks/create.html.twig', [ 'CreateTrick' => $form->createView()]);
    }

    #[Route('/update/{id}', name:'update')]
    public function update(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, Tricks $tricks): Response
    {
        $entityManager = $doctrine->getManager();
        $updateForm = $this->createForm(UpdateTrickType::class, $tricks);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()) {

            $setName = $updateForm->get('name')->getData();
            $setDescription = $updateForm->get('description')->getData();
            $setType = $updateForm->get('type')->getData();
            $setPhoto = $updateForm->get('photo')->getData();
            $setVideo = $updateForm->get('video')->getData();
            $setHeader = $updateForm->get('header')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($setPhoto) {
                $originalFilename = pathinfo($setPhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setPhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setPhoto->move(
                        $this->getParameter('UpdateTrick_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setPhoto($newFilename);
            }
            if ($setHeader) {
                $originalFilename = pathinfo($setHeader->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setHeader->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setHeader->move(
                        $this->getParameter('UpdateTrick_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setHeader($newFilename);
            }
            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
        return $this->render('/tricks/update.html.twig', [ 'tricks'=> $tricks, 'UpdateTrick' => $updateForm->createView()]);
    }

    #[Route('/updateHeader/{id}', name:'updateHeader')]
    public function updateHeader(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, Tricks $tricks): Response
    {
        $entityManager = $doctrine->getManager();
        $updateHeaderForm = $this->createForm(UpdateHeaderType::class, $tricks);
        $updateHeaderForm->handleRequest($request);

        if ($updateHeaderForm->isSubmitted() && $updateHeaderForm->isValid()) {

            $setHeader = $updateHeaderForm->get('header')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($setHeader) {
                $originalFilename = pathinfo($setHeader->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setHeader->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setHeader->move(
                        $this->getParameter('UpdateTrick_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setHeader($newFilename);
            }
            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
        return $this->render('/tricks/updateHeader.html.twig', [ 'tricks'=> $tricks, 'UpdateHeader' => $updateHeaderForm->createView()]);

    }

    #[Route('/updatePhoto/{id}', name:'updatePhoto')]
    public function updatePhoto(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, Tricks $tricks): Response
    {
        $entityManager = $doctrine->getManager();
        $updatePhotoForm = $this->createForm(UpdatePhotoType::class, $tricks);
        $updatePhotoForm->handleRequest($request);

        if ($updatePhotoForm->isSubmitted() && $updatePhotoForm->isValid()) {

            $setPhoto = $updatePhotoForm->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($setPhoto) {
                $originalFilename = pathinfo($setPhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$setPhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $setPhoto->move(
                        $this->getParameter('UpdateTrick_photo'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $tricks->setPhoto($newFilename);
            }
            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
        return $this->render('/tricks/updatePhoto.html.twig', [ 'tricks'=> $tricks, 'UpdatePhoto' => $updatePhotoForm->createView()]);

    }

    #[Route('/updateVideo/{id}', name:'updateVideo')]
    public function updateVideo(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, Tricks $tricks): Response
    {
        $entityManager = $doctrine->getManager();
        $updateVideoForm = $this->createForm(UpdateVideoType::class, $tricks);
        $updateVideoForm->handleRequest($request);

        if ($updateVideoForm->isSubmitted() && $updateVideoForm->isValid()) {

            $setVideo = $updateVideoForm->get('video')->getData();

            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
        return $this->render('/tricks/updateVideo.html.twig', [ 'tricks'=> $tricks, 'UpdateVideo' => $updateVideoForm->createView()]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Tricks $tricks, ManagerRegistry $doctrine, ): RedirectResponse
    {
        if($tricks){
            $manager = $doctrine->getManager();
            $manager->remove($tricks);
            $manager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
    }

    #[Route('/deleteHeader/{id}', name: 'deleteHeader')]
    public function deleteHeader(Tricks $tricks, ManagerRegistry $doctrine): RedirectResponse
    {
        if($tricks){
            $tricks->setHeader("");
            $manager = $doctrine->getManager();
            $manager->persist($tricks);
            $manager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
    }

    #[Route('/deletePhoto/{id}', name: 'deletePhoto')]
    public function deletePhoto(Tricks $tricks, ManagerRegistry $doctrine): RedirectResponse
    {
        if($tricks){
            $tricks->setPhoto("");
            $manager = $doctrine->getManager();
            $manager->persist($tricks);
            $manager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
    }

    #[Route('/deleteVideo/{id}', name: 'deleteVideo')]
    public function deleteVideo(Tricks $tricks, ManagerRegistry $doctrine): RedirectResponse
    {
        if($tricks){
            $tricks->setVideo("");
            $manager = $doctrine->getManager();
            $manager->persist($tricks);
            $manager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }
    }

    #[Route('/trick/{name}', name: 'single')]
    public function single(Tricks $tricks, CommentsRepository $commentsRepository, ManagerRegistry $doctrine, UserInterface $user, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $comments = new Comments();
        $commentForm = $this->createForm(AddCommentType::class, $comments);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $setContent = $commentForm->get('content')->getData();
            $comments->setTricksId($tricks);
            $comments->setUsers($user);
            

            $comments->dateTime = new DateTime();
            $entityManager->persist($comments);
            $entityManager->flush();

            return $this->redirectToRoute('single', ['name'=>$tricks->getName()]);
        }

        return $this->render('/tricks/single.html.twig', ['tricks'=> $tricks,
        'comments'=> $commentsRepository->findBy(['tricks_Id' =>$tricks->id]),
        'AddComment' => $commentForm->createView()]);
    }   
}
