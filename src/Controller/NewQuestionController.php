<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\User;
use App\Form\QuestionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewQuestionController extends AbstractController
{
    #[Route('/new_question', name: 'new_question')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionFormType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if ($user && $user->getNom()) {
                $question->setAuteur($user->getNom());
            } else {
                throw new \Exception("Utilisateur non connecté ou pseudo manquant");
            }
            $question->setLifespan(new \DateTime());

            $timestamp = (new \DateTime())->getTimestamp();
            $randomData = uniqid();
            $uniqueId = sha1($timestamp . $randomData);

            $photo = $form->get('photo')->getData();
            if ($photo) {
                $photoData = file_get_contents($photo->getPathname());
                $question->setImage($photoData);
            }

            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('question');
        }

        return $this->render('new_question/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
