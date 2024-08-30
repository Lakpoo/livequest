<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'question')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $questions = $entityManager->getRepository(Question::class)
            ->findBy([], ['lifespan' => 'DESC']);

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}