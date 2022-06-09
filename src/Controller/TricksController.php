<?php

namespace App\Controller;
use App\Entity\Tricks;
use App\Form\CreateTrickType;
use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $tricks = new Tricks();
        $form = $this->createForm(CreateTrickType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tricks->setName($form->get('name')->getData())
            ->setDescription($form->get('description')->getData())
            ->setType($form->get('type')->getData())
            ->setPhoto($form->get('photo')->getData())
            ->setVideo($form->get('video')->getData());

            $entityManager->persist($tricks);
            $entityManager->flush();

            return $this->redirect('/tricks');

        }

        return $this->render('/tricks/create.html.twig', [ 'CreateTrick' => $form->createView()]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Tricks $tricks = null, ManagerRegistry $doctrine): RedirectResponse
    {
        if($tricks){
            $manager = $doctrine->getManager();
            $manager->remove($tricks);
            $manager->flush();
            $this->addFlash(type:'success', message: 'Le trick est supprimé avec succès');

        }else{

            $this->addFlash(type:'success', message: 'Le trick est inexistant');

        }
        return $this->redirectToRoute(route:'/tricks');
    }

    #[Route('/trick/{name}', name: 'single')]
    public function single(Tricks $tricks, CommentsRepository $commentsRepository): Response
    {
         return $this->render('/tricks/single.html.twig', ['tricks'=> $tricks, 'comments'=> $commentsRepository->findBy(['tricks_Id' =>$tricks->id])]);
    }
    
    
}
