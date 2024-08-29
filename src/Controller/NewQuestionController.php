<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewQuestionController extends AbstractController
{
    #[Route('/new/question', name: 'new_question')]
    public function index(): Response
    {
        return $this->render('new_question/index.html.twig', [
            'controller_name' => 'NewQuestionController',
        ]);
    }
}
