<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Results;
use App\Entity\Test;
use App\Entity\Question;
use App\Form\ResultsType;
use App\Form\TestType;
use App\Form\QuestionType;
use App\Form\AnswerType;
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
        $answer = new Answer();
        $answer->setQuestionId($question);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
//        dump($question);
        if ($form->isSubmitted()) {
//            $id = $test->getId();
//            dump($id);
//            $answer = new Answer();
//            $answer->setQuestionId($question);
//            $form = $this->createForm(Answer::class, $question);
//            $form->handleRequest($request);
//            dump($answer);
//            dump($request->request->get('answer'));
//            dump($request->request->get('correctness'));
//            $answer->setAnswer($request->request->get('answer'));
//            $answer->setCorrectness($request->request->get('correctness'));
//            $answer->setAnswer('answer');
//            $answer->setCorrectness(1);
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
//            $entityManager->persist($answer);
            $entityManager->flush();

            return $this->redirectToRoute('answer_new', [
                'id' => $question->getId(),
                'question' => $question
            ]);

        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
//            'id' => $id
        ]);
    }

    /**
     * @Route("{id}/new_answer", name="answer_new", methods={"GET","POST"})
     */
    public function new_answer(Request $request, Question $question): Response
    {
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('App:Answer')->createQueryBuilder('q')
            ->where('q.question_id ='.$question->getId())
            ->getQuery()
            ->getResult();
        $answer = new Answer();
        $answer->setQuestionId($question);
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

//        $em = $this->getDoctrine()->getManager();
//        $questions = $em->getRepository('App:Question')->createQueryBuilder('q')
//            ->getQuery()
//            ->getResult();


//        dump($questions);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();
            return $this->redirectToRoute('answer_new', [
                'id' => $question->getId(),
            ]);
        }
        return $this->render('answer/new.html.twig', [
            'id' => $question->getId(),
            'answer' => $answer,
            'question' => $question,
            'form' => $form->createView(),
            'answers' => $answers,
        ]);
    }
    /**
     * @Route("/{id}do_test", name="doTest", methods={"GET"})
     */
    public function doTest(Request $request, Test $test): Response
    {
        $TestId = $test->getId();
        $em = $this->getDoctrine()->getManager();
//        $question = $em->getRepository("App:Question")->findOneBy(['test' => $TestId]);
        $questions = $em->getRepository("App:Question")->findAll();
//        $QuestionId = $question->getId();
//        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository("App:Answer")->findAll();
//        dump($answers);
        dump($questions);

        $results = new Results();
        $form = $this->createForm(ResultsType::class, $results);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($results);
            $entityManager->flush();
//            $QuestionId++;
//            return $this->redirectToRoute('doTest', [
//                'questionId' => $QuestionId,
//            ]);
        }



//        if ($form->isSubmitted()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $qId = 71;
//            $results->setQuestion($qId);
//            $results->setTakenAnswer(28);
//            $entityManager->persist($results);
//            $entityManager->flush();
//            return $this->render('test/show.html.twig');
//        }
        return $this->render('test/show.html.twig', [
            'test' => $test,
            'questions' => $questions,
            'answers' => $answers,
            'form' => $form->createView(),
//            'questionId' => $QuestionId,
//            'id' => $id,
            'testId' => $test->getId(),
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