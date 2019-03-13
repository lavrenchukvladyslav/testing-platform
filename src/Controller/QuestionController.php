<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Answer;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question")
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="question_index", methods={"GET"})
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        dump($questionRepository->findAll());
        return $this->render('question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="question_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $question = new Question();


        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $answer = new Answer();
            $questuon_id = $question->getId();
            dump($questuon_id);
            $answer->setQuestionId($questuon_id);
            $answer->setAnswer('answer');
            $answer->setCorrectness('1');

//            $answerField = $request->request->get('answer');
//            $correctnessField = $request->request->get('correctness');
//            $questuon_id = $question->getId();
//            $questuon_id = 1;
//            dump($answerField);

//            $answer->setAnswer($answerField);
//            $answer->setCorrectness($correctnessField);
//            $answer->setQuestionId($questuon_id);
//            $question->setAnswer(1);
            dump($question);
//            dump($answer);
//            $em->persist($answer);
//            $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

//            return $this->redirectToRoute('question_index');
        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="question_show", methods={"GET"})
     */
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }


    /**
     * @Route ("/tests", name="test")
     * @param Request $request
     * @return Response
     */
    public function tests(Request $request,Question $question): Response
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('App:Question')->createQueryBuilder('q')
            ->getQuery()
            ->getResult();
        dump($question);


//        $question_id = $question->getId();
//        $em = $this->getDoctrine()->getManager();
//        $answers = $em->getRepository('App:Answer')->createQueryBuilder('q')
//            ->where('q.question_id ='.$question_id)
//            ->getQuery()
//            ->getResult();
//        dump($answers);


        return $this->render('question/tests.html.twig', [
//            'question' => $question,
//            'question' => $question,
//            'answers' => $answers,
        ]);
    }

    /**
     * @Route ("/test/{id}", name="test")
     * @return Response
     * @param $questionId
     */
    public function test(Request $request,Question $question): Response
    {

        $question_id = $question->getId();
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('App:Answer')->createQueryBuilder('q')
            ->where('q.question_id ='.$question_id)
            ->getQuery()
            ->getResult();
        dump($answers);


        return $this->render('question/test.html.twig', [
//            'question' => $question,
            'answers' => $answers,
        ]);
    }

    // to do добавить поле test_name в question, вывести тест по тест_нейм, в твиге foreach question > foreach answer where a.question_id = q.id + checbox if correctness true среднне арифметическое всех ответов + new entity test results


    /**
     * @Route("/{id}/edit", name="question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_index', [
                'id' => $question->getId(),
            ]);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="question_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('question_index');
    }


}
