<?php
namespace App\Controller;

use App\Entity\Answers;
use App\Entity\Group;
use App\Entity\Questions;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends ApiController
{
    /**
     * @Route("/")
     */
    public function HomePage()
    {
        return $this->render('base.html.twig');
    }


    function flush(){
        $this->getDoctrine()->getManager()->flush();
    }
    function persist($data){
        $this->getDoctrine()->getManager()->persist($data);
    }
    function remove($data){
        $this->getDoctrine()->getManager()->remove($data);
        $this->getDoctrine()->getManager()->flush();
    }

    function request(){
        return Request::createFromGlobals();
    }
    function requestAll(){
        $request = Request::createFromGlobals();
        return $request->request->all();
    }

    /**
     * @param Questions $question
     * @return array
     */
    function questionToArray($question){
        $data = [
            'Id' => $question->getId(),
            'Question' => $question->getQuestion(),
            'QuestionBankId' => $question->getQuestionBank()->getId(),
            'Type'      => $question->getType(),
            'Answers'  => []
        ];
        $answers = $this->getDoctrine()->getRepository(Answers::class)->findBy(array('question' => $question));

        /** @var Answers $a */
        foreach ($answers as $a){
            $answer = [
                'Id' => $a->getId(),
                'Asnwer' => $a->getAnswer(),
            ];
            $data['Answers'][] = $answer;
        }
        return $data;
    }

    //TODO:: Implement if can edit
    function canEdit($id, $entity){
        /** @var Users $user */
        $user = $this->getUser();
        switch ($entity){
            case 'Answers':
                return true;
            case 'QuestionBanks':
                return true;
            case 'Questions':
                return true;
            default:
                return true;
        }
    }

    function canDelete($id, $entity){
        /** @var Users $user */
        $user = $this->getUser();
        switch ($entity){
            case 'Answers':
                return true;
            case 'QuestionBanks':
                return true;
            case 'Questions':
                return true;
            default:
                return true;
        }
    }

}