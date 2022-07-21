<?php

namespace App\Controller;
use App\Entity\Tricks;
use App\Entity\Comments;
use App\Entity\Users;
use App\Form\CreateTrickType;
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

#[Route('/tricks', name: 'tricks_')]
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
            $tricks->created_at = new DateTime();
            $tricks->updated_at = new DateTime();
            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirect('/tricks');
        }

        return $this->render('/tricks/create.html.twig', [ 'CreateTrick' => $form->createView()]);
    }

    #[Route('/update/{id}', name:'update')]
    public function update(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger, Tricks $tricks): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(UpdateTrickType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $setName = $form->get('name')->getData();
            $setDescription = $form->get('description')->getData();
            $setType = $form->get('type')->getData();
            $setPhoto = $form->get('photo')->getData();
            $setVideo = $form->get('video')->getData();

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

            return $this->redirect('/tricks');
        }
        return $this->render('/tricks/update.html.twig', [ 'tricks'=> $tricks, 'UpdateTrick' => $form->createView()]);

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Tricks $tricks, ManagerRegistry $doctrine, ): RedirectResponse
    {
        if($tricks){
            $manager = $doctrine->getManager();
            $manager->remove($tricks);
            $manager->flush();

            return $this->redirect('/tricks');
        }
    }

    #[Route('/trick/{name}', name: 'single')]
    public function single(Tricks $tricks, CommentsRepository $commentsRepository, Request $request ): Response
    {
        $form = $this->createForm(AddCommentType::class);
        $form->handleRequest($request);

         return $this->render('/tricks/single.html.twig', ['tricks'=> $tricks, 
         'comments'=> $commentsRepository->findBy(['tricks_Id' =>$tricks->id]),
         'AddComment' => $form->createView()]);
    }
    
}
