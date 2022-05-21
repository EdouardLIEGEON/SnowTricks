<?php

namespace App\Controller;
use App\Entity\Tricks;
use App\Repository\TricksRepository;
use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    #[Route('/{name}', name: 'single')]
    public function single(Tricks $tricks, CommentsRepository $commentsRepository): Response
    {

        return $this->render('tricks/single.html.twig', ['tricks'=> $tricks, 'comments'=> $commentsRepository->findAll()]);
    }
    #[Route('/update', name: 'update')]
    public function update():Response
    {
        return $this->render('tricks/update.html.twig');

    }
    #[Route('/create', name:'create')]
    public function create(): Response
    {
        return $this->render('tricks/create.html.twig' );
    }
    
}
