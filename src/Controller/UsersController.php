<?php
namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AppController
{

    /**
     * @Route("/users", methods={"POST"})
     */
    public function register()
    {
        $user = new Users();
        $data = $this->requestAll();

        if (empty($data['username'])) $this->respondWithErrors('05', 'Username is not set');
        $username = $data['username'];
        $u = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array('usernameCanonical' => strtolower($username), 'enabled' => true));
        if (!empty($u)) return $this->respondWithErrors('03', 'Username is already in use');

        if (empty($data['email'])) $this->respondWithErrors('06', 'Email is not set');
        $email = $data['email'];
        $u = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array('emailCanonical' => strtolower($email)));
        if (!empty($u)) return $this->respondWithErrors('04', 'Email is already in use');
        if (!empty($data['name']))
            $user->setName($data['name']);
        if (!empty($data['surname']))
            $user->setName($data['surname']);

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        if (empty($data['password'])) $this->respondWithErrors('07', 'Password is not set');
        $user->setPlainPassword($data['password']);
        $this->persist($user);
        $this->flush();
        return $this->respondCreated($user);
    }
    /**
     * @Route("/api/users{id}", methods={"PUT"})
     */
    public function update($id)
    {
        $request = $this->requestAll();
        if (!$this->canEdit($id, 'Users')) $this->respondNoPermission();
        /** @var Users $user */
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        if (empty($user)) return $this->respondWithErrors('03', 'User not found');

        if (!empty($request['name'])) $user->setName($request['name']);
        if (!empty($request['surname'])) $user->setName($request['surname']);
        return $this->respond(array('0' => 'Ok'));


    }
    /**
     * @Route("/api/users{id}", methods={"GET"})
     */
    public function get($id)
    {
        /** @var Users $user */
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        if (empty($user)) return $this->respondWithErrors('03', 'User not found');
        $data['Id'] = $user->getId();
        $data['Username'] = $user->getUsername();
        $data['Name'] = $user->getName();
        $data['Surname'] = $user->getSurname();
        return $this->respond($data);
    }
    /**
     * @Route("/api/users", methods={"GET"})
     */
    public function getAll()
    {
        $users = $this->getDoctrine()->getRepository(Users::class)->findAll();
        $data = [];
        /** @var Users $u */
        foreach($users as $u){
            $d['Id'] = $u->getId();
            $d['Username'] = $u->getUsername();
            $d['Name'] = $u->getName();
            $d['Surname'] = $u->getSurname();

            $data[] = $d;
        }
        return $this->respond($data);

    }
    /**
     * @Route("/api/users{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        if (!$this->canDelete($id, 'Users')) $this->respondNoPermission();

        /** @var Users $user */
        $user = $this->getDoctrine()->getRepository(Users::class)->find($id);
        if (empty($user)) return $this->respondWithErrors('03', 'User not found');

        $user->setEnabled(false);

        return $this->respond(array('0' => 'Ok'));

    }
}