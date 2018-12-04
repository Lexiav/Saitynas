<?php
namespace App\Controller;

use App\Entity\Groups;
use App\Entity\UserGroups;
use App\Entity\Users;
use http\Env\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuestionBankController
 * @package App\Controller
 */
class GroupController extends AppController
{
    /**
     * @Route("/api/groups", methods={"GET"})
     */
    public function getAll()
    {
        /** @var Users $user */
        $user = $this->getUser();
        $userGroups = $this->getDoctrine()->getRepository(UserGroups::class)->findBy(array('user' => $user));
        $data = [];

        /** @var UserGroups $ug */
        foreach ($userGroups as $ug){
            $d['Name'] = $ug->getGroup()->getName();
            $d['Id'] = $ug->getGroup()->getId();
            $d['Type'] = $ug->getType();
            $data[] = $d;
        }
        return $this->respond($data);
    }

    /**
     * @Route("/api/groups/{id}", methods={"GET"})
     */
    public function show($id)
    {
        /** @var Groups $group */
        $group = $this->getDoctrine()->getRepository(Groups::class)->find($id);

        if (! $group) {
            return $this->respondNotFound();
        }

        $d['Id'] = $group->getId();
        $d['Name'] = $group->getName();
        $d['Users'] = [];
        $users = $this->getDoctrine()->getRepository(UserGroups::class)->findBy(array('group' => $group));
        /** @var UserGroups $u */
        foreach ($users as $u){
            $ud['id'] = $u->getUser()->getId();
            $ud['Username'] = $u->getUser()->getUsername();
            $ud['Name'] = $u->getUser()->getName();
        }
        return $this->respond($d);
    }

    /**
     * @Route("/api/groups", methods={"POST"})
     */
    public function create()
    {
        $data = $this->requestAll();
        if(empty($data['name'])) $this->respondWithErrors('03', 'Name is not set');

        $group = new Groups();

        $group->setName($data['Name']);
        $this->persist($group);

        $d['Id'] = $group->getId();
        $d['Name'] = $group->getName();

        $ug = new UserGroups();

        $ug->setGroup($group);
        /** @var Users $user */
        $user = $this->getUser();
        $ug->setUser($user);
        $ug->setType(1);
        $this->persist($ug);
        $this->flush();
        return $this->respondCreated($d);
    }

    /**
     * @Route("/api/groups/{id}" , methods={"PUT"})
     */
    public function update($id)
    {
        if (!$this->canEdit($id, 'Groups')) return $this->respondNoPermission();
        $data = $this->requestAll();

        if (empty($data['id'])) return $this->respondWithErrors('03','Group id not set');
        if (empty($data['name'])) return $this->respondWithErrors('04','Group name not set');


        /** @var Groups $group */
        $group = $this->getDoctrine()->getRepository(Groups::class)->find($data['id']);

        if (empty($group)) return $this->respondNotFound('Group not found');

        $group->setName($data['name']);

        return $this->respond(array(0 => 'Ok'));

    }

    /**
     * @Route("/api/groups/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        if (!$this->canDelete($id, 'Groups')) return $this->respondNoPermission();

        $group = $this->getDoctrine()->getRepository(Groups::class)->find($id);
        /** @var Users $users */
        $users = $this->getDoctrine()->getRepository(UserGroups::class)->findBy(array('group' => $group));
        $this->RemoveUsersFromGroup($group, $users);
        if(!empty($group)) $this->respondWithErrors('05', 'Group not found');

        $this->remove($group);
        $this->flush();

        return $this->respond(array(0 => 'Ok'));
    }

    /**
     * @Route("/api/usergroups", methods={"POST"})
     */
    public function addToGroup(){

        $request = $this->requestAll();
        if (empty($request['id'])) return $this->respondWithErrors('03', 'Group id is empty');
        if (!$this->canEdit($request['id'], 'Answers')) return $this->respondNoPermission();

        /** @var Groups $group */
        $group = $this->getDoctrine()->getRepository(Groups::class)->find($request['id']);

        if (empty($group)) return $this->respondNotFound('Group not found');
        $usersIds = $request['users'];

        $users = $this->getDoctrine()->getRepository(UserGroups::class)->findBy(array('group' => $group));
        $uIds = [];
        /** @var UserGroups $u */
        foreach ($users as $u){
            $uIds[] = $u->getUser()->getId();
        }
        $response = [];
        foreach ($usersIds as $u){
            if (!in_array($u, $uIds)){
                $ug = new UserGroups();
                /** @var Users $user */
                $user = $this->getDoctrine()->getRepository(Users::class)->find($u);
                $ug->setUser($user);
                $ug->setGroup($group);
                $ug->setType(2);
                $this->persist($ug);
                $this->flush();
                $r['Id'] = $ug->getId();
                $r['GroupId'] = $ug->getGroup()->getId();
                $r['UserId'] = $ug->getUser()->getId();
                $response[] = $r;
            }
        }

        return $this->respondCreated($response);
    }
    /**
     * @Route("/api/usergroups", methods={"DELETE"})
     */
    public function removeFromGroup(){
        $request = $this->requestAll();

        if (empty($request['id'])) return $this->respondWithErrors('03', 'Group id is empty');
        if (!$this->canEdit($request['id'], 'Answers')) return $this->respondNoPermission();

        /** @var Groups $group */
        $group = $this->getDoctrine()->getRepository(Groups::class)->find($request['id']);

        if (empty($group)) return $this->respondNotFound('Group not found');
        $usersIds = $request['users'];
        $this->RemoveUsersFromGroup($group, $usersIds);

        return $this->respond(array('0' => 'Ok'));
    }


    public function RemoveUsersFromGroup($group, $users){
        foreach ($users as $u){
            /** @var Users $user */
            $user = $this->getDoctrine()->getRepository(Users::class)->find($u);
            /** @var UserGroups $ug */
            $ug = $this->getDoctrine()->getRepository(UserGroups::class)->findOneBy(array('user' => $user, 'group' => $group));
            if (!empty($ug)){
                $this->remove($ug);
            }
        }
    }
}