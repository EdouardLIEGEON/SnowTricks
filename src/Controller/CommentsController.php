<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tricks', name: 'comments_')]
class CommentsController extends AbstractController
{
    public function single(CommentsRepository $commentsRepository): Response
    {
        return $this->render('tricks/single.html.twig', ['comments' => $commentsRepository->findAll()]);
    }
    
}
