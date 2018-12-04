<?php
namespace App\Controller;

use App\Entity\QuestionBank;
use App\Entity\Users;
use App\Repository\QuestionBankRepository;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class QuestionBankController
 * @package App\Controller
 */
class QuestionBankController extends AppController
{
    /**
     * @Route("/api/questionbanks", methods={"GET"})
     */
    public function getAll()
    {
        /** @var Users $user */
        $user = $this->getUser();
        $questionBanks = $this->getDoctrine()->getRepository(QuestionBank::class)->findBy(array('user' => $user));
        $data = [];

        /** @var QuestionBank $qb */
        foreach ($questionBanks as $qb){
            $d['Id'] = $qb->getId();
            $d['Title'] = $qb->getTitle();
            $d['CreatedOn'] = $qb->getCreatedOn();
            /** @var Users $user */
            $user = $qb->getCreatedBy();
            $u['Id'] = $user->getId();
            $u['Name'] = $user->getFullName();
            $d['User'] = $u;
            $data[] = $d;
        }
        return $this->respond($questionBanks);
    }

    /**
     * @Route("/api/questionbanks/{id}", methods={"GET"})
     */
    public function show($id)
    {
        /** @var QuestionBank $questionBank */
        $questionBank = $this->getDoctrine()->getRepository(QuestionBank::class)->find($id);

        if (! $questionBank) {
            return $this->respondNotFound();
        }

        $d['Id'] = $questionBank->getId();
        $d['Title'] = $questionBank->getTitle();
        $d['CreatedOn'] = $questionBank->getCreatedOn();
        /** @var Users $user */
        $user = $questionBank->getCreatedBy();
        $u['Id'] = $user->getId();
        $u['Name'] = $user->getFullName();
        $d['User'] = $u;

        return $this->respond($d);
    }

    /**
     * @Route("/api/questionbanks", methods={"POST"})
     */
    public function create()
    {

        $request = $this->Request();
        $title =  $request->request->get('title');

        /** @var Users $user */
        $user = $this->getUser();

        $questionBank = new QuestionBank();

        $questionBank->setCreatedBy($user);
        $questionBank->setTitle($title);
        $questionBank->setCreatedOn(new \DateTime());
        $this->persist($questionBank);
        $this->flush();
        $d['Id'] = $questionBank->getId();
        $d['Title'] = $questionBank->getTitle();
        $d['CreatedOn'] = $questionBank->getCreatedOn();
        /** @var Users $user */
        $user = $questionBank->getCreatedBy();
        $u['Id'] = $user->getId();
        $u['Name'] = $user->getFullName();
        $d['User'] = $u;
        return $this->respondCreated($d);
    }

    /**
     * @Route("/api/questionbanks/{id}" , methods={"PUT"})
     */
    public function update($id)
    {
        if (!$this->canEdit($id, 'QuestionBanks')) return $this->respondNoPermission();
        $request = $this->request();
        $title = $request->request->get('title');
        if(empty($title)) return $this->respondWithErrors('04', 'Title field is empty');

        /** @var QuestionBank $questionBank */
        $questionBank = $this->getDoctrine()->getRepository(QuestionBank::class)->find($id);

        if(!empty($questionBank)) $this->respondWithErrors('05', 'Question Bank not found');

        $questionBank->setTitle($title);

        $this->persist($questionBank);
        $this->flush();
        return $this->respond(array(0 => 'Ok'));
    }

    /**
     * @Route("/api/questionbanks/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        if (!$this->canDelete($id, 'QuestionBanks')) return $this->respondNoPermission();

        $questionBank = $this->getDoctrine()->getRepository(QuestionBank::class)->find($id);

        if(!empty($questionBank)) $this->respondWithErrors('05', 'Question Bank not found');

        $this->remove($questionBank);
        $this->flush();

        return $this->respond(array(0 => 'Ok'));
    }

}