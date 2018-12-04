<?php
namespace App\Controller;

use App\Entity\QuestionBank;
use App\Entity\Group;
use App\Entity\Questions;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class QuestionBankController
 * @package App\Controller
 */
class QuestionsController extends AppController
{
    /**
     * @Route("/api/questions", methods={"GET"})
     */
    public function getAll()
    {
       $questions = $this->getDoctrine()->getRepository(Questions::class)->findAll();
       $data = array();
       /** @var Questions $q */
        foreach ($questions as $q){
           $data[] = $this->questionToArray($q);
       }
    }

    /**
     * @Route("/api/questions/{id}", methods={"GET"})
     */
    public function show($id)
    {

        /** @var Questions $question */
        $question = $this->getDoctrine()->getRepository(Questions::class)->find($id);
        if (!$question) return $this->respondWithErrors('03', 'Question not found');

        $data = $this->questionToArray($question);

        return $this->respond($data);
    }

    /**
     * @Route("/api/questions", methods={"POST"})
     */
    public function create()
    {
        $request = $this->requestAll();
        if (empty($request['questionBank'])) return $this->respondWithErrors('03', 'Question bank is not set');
        if (!$this->canEdit($request['questionBank'], 'QuestionsBank')) return $this->respondNoPermission();

        $questionBank = $this->getDoctrine()->getRepository(QuestionBank::class)->find($request['questionBank']);

        if (empty($questionBank)) $this->respondWithErrors('04', 'Question bank not found');
        if (empty($request['question'])) $this->respondWithErrors('05', 'Question is not set');
        if (empty($request['type'])) $request['type'] = 1;

        $question = new Questions();
        $question->setQuestion($request['question']);
        $question->setQuestionBank($questionBank);
        $question->setType($request['type']);

        $this->persist($question);
        $this->flush();

        $d['id'] = $question->getId();
        $d['type'] = $question->getType();
        $d['questionBank'] = $question->getQuestionBank()->getId();
        $d['question'] = $question->getQuestion();

        return $this->respondCreated($d);
    }

    /**
     * @Route("/api/questions/{id}" , methods={"PUT"})
     */
    public function update($id)
    {
        $request = $this->requestAll();
        if (!$this->canEdit($id, 'Questions')) return $this->respondNoPermission();

        /** @var Questions $question */
        $question = $this->getDoctrine()->getRepository(Questions::class)->find($id);
        if (empty($question)) return $this->respondWithErrors('03', 'Question not found');

        if (!empty($request['question'])) $question->setQuestion($request['question']);
        if (!empty($request['type'])) $question->setType($request['type']);

        $this->persist($request);
        $this->flush();

        return $this->respond(array(0 => 'Ok'));

    }

    /**
     * @Route("/api/questions/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        if (!$this->canDelete($id, 'Questions')) return $this->respondNoPermission();

        $question = $this->getDoctrine()->getRepository(Questions::class)->find($id);

        if(!empty($question)) $this->respondWithErrors('05', 'Question not found');

        $this->remove($question);

        return $this->respond(array(0 => 'Ok'));
    }

}