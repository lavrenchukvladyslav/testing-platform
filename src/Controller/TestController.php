<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Test;
use App\Entity\Question;
use App\Form\TestType;
use App\Form\QuestionType;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/", name="test_index", methods={"GET"})
     */
    public function index(TestRepository $testRepository): Response
    {
        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="test_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('test_index');
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/new_question", name="question_new", methods={"GET","POST"})
     */
    public function new_question(Request $request, Test $test): Response
    {
        $question = new Question();
        $question->setTest($test);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
//        dump($question);
        if ($form->isSubmitted()) {
//            $id = $test->getId();
//            dump($id);



            $answer = new Answer();
            $form = $this->createForm(Answer::class, $question);
            $form->handleRequest($request);
            $answer->setQuestionId($question);
            dump($answer);
//            dump($request->request->get('answer'));
//            dump($request->request->get('correctness'));
//            $answer->setAnswer($request->request->get('answer'));
//            $answer->setCorrectness($request->request->get('correctness'));

            $answer->setAnswer('answer');
            $answer->setCorrectness(1);

//            $answer = new Answer();
//            $questuon_id = $question->getId();
//            dump($questuon_id);
//            $question->setTest($id);
//            $answer->setQuestionId('1');

//            $answer->setAnswer('answer');
//            $answer->setCorrectness('1');

//
//            $question->setQuestion(1);
//            $question->setTest('5');

//            $answerField = $request->request->get('answer');
//            $correctnessField = $request->request->get('correctness');
//            $questuon_id = $question->getId();
//            $questuon_id = 1;
//            dump($answerField);

//            $answer->setAnswer($answerField);
//            $answer->setCorrectness($correctnessField);
//            $answer->setQuestionId($questuon_id);
//            $question->setAnswer(1);
//            dump($answer);
//            $em->persist($answer);
//            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
//            $entityManager->flush();
//            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();

//            return $this->redirectToRoute('question_index');

        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
//            'id' => $id
        ]);
    }

    /**
     * @Route("/{id}", name="test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        $em = $this->getDoctrine()->getManager();
        $id = $test->getId();
        $question = $em->getRepository('App:Question')->createQueryBuilder('q')
//            ->where('q.id ='.$question_id)
            ->getQuery()
            ->getResult();

        $answers = $em->getRepository('App:Answer')->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
        dump($question);
        dump($answers);
        return $this->render('test/show.html.twig', [
            'test' => $test,
            'questions' => $question,
            'answers' => $answers,
            'id' => $id
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Test $test): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_index', [
                'id' => $test->getId(),
            ]);
        }

        return $this->render('test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_index');
    }
}
// to do save answers to the Results entity check results with correctness and show result % max 100%
// to do create question with answer in 1 page + create 4 answers in 1 page + add answer fields dynamic + create many questions with answers dynamic
// to do edit questions and answers
// to do for admin all content for user only show tests