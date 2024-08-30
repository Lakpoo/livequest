<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;

class NewQuestionController extends AbstractController
{
    #[Route('/new_question', name: 'new_question')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();

        $form = $this->createForm(QuestionFormType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setLifespan(new \DateTime());

            $question->setUuid(Uuid::v4());

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $newFilename = uniqid().'.'.$photo->guessExtension();
                $photo->move(
                    $this->getParameter('photos_directory'),
                    $newFilename
                );
                $question->setPhotoFilename($newFilename);
            }

            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('question_success');
        }

        return $this->render('new_question/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

