<?php
namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Cage;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AppController
{

    /**
     * @Route("/animals", methods={"GET"})
     */
    public function getAll()
    {
        $animals = $this->getDoctrine()->getRepository(Animal::class)->findAll();
        $data = [];
        /** @var Animal $animal */
        foreach($animals as $animal){
            $d['Name'] = $animal->getName();
            $d['Age'] = $animal->getAge();
            $d['Cage'] = $animal->getCage()->getId();
            $d['Species'] = $animal->getSpecies();
            $data[] = $d;

        }

        return $this->respond($data);
    }

    /**
     * @Route("/animals", methods={"POST"})
     */
    public function create()
    {
        $request = $this->requestAll();
        if(empty($request['name']))
        {
            return $this->respondWithErrors('Name not found');
        }
        if(empty($request['age']))
        {
            return $this->respondWithErrors('Age not found');
        }
        if(empty($request['cageId']))
        {
            return $this->respondWithErrors('CageId not found');
        }
        if(empty($request['species']))
        {
            return $this->respondWithErrors('Species not found');
        }
        $animal = new Animal();
        $animal->setName($request['name']);
        $animal->setAge($request['age']);
        $cage = $this->getDoctrine()->getRepository(Cage::class)->find($request['cageId']);

        if (empty($cage)) return $this->respondWithErrors('Cage not found');

        $animal->setCage($cage);
        $animal->setSpecies($request['species']);

        $this->persist($animal);
        $this->flush();

        $data['Name'] = $animal->getName();
        $data['Age'] = $animal->getAge();
        $data['CageId'] = $animal->getCage()->getId();
        $data['Species'] = $animal->getSpecies();
        return $this->respondCreated($data);
    }
    /**
     * @Route("/animal{id}", methods={"PUT"})
     */
    public function update($id)
    {
        $request = $this->requestAll();

        if(empty($request['name']))
        {
            return $this->respondWithErrors('Name not found');
        }
        if(empty($request['age']))
        {
            return $this->respondWithErrors('Age not found');
        }
        if(empty($request['cageId']))
        {
            return $this->respondWithErrors('CageId not found');
        }
        if(empty($request['species']))
        {
            return $this->respondWithErrors('Species not found');
        }

        /** @var Animal $animal */
        $animal = $this->getDoctrine()->getRepository(Animal::class)->find($id);

        $animal->setName($request['name']);
        $animal->setAge($request['age']);

        $cage = $this->getDoctrine()->getRepository(Cage::class)->find($request['cageId']);
         if (empty($cage)) return $this->respondWithErrors('Cage not found');


        $animal->setCage($cage);
        $animal->setSpecies($request['species']);

        $this->persist($animal);
        $this->flush();

        return $this->respond(array('Ok'));

    }
    /**
     * @Route("/animals/{id}", methods={"GET"})
     */
    public function get($id)
    {
        /** @var Animal $animal */
        $animal = $this->getDoctrine()->getRepository(Animal::class)->find($id);
        if (empty($animal)) return $this->respondWithErrors('03', 'Animal not found');
        $data['name'] = $animal->getName();
        $data['age'] = $animal->getAge();
        $data['cageId'] = $animal->getCage()->getId();
        $data['species'] = $animal->getSpecies();
        return $this->respond($data);
    }

    /**
     * @Route("/animals/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $animal = $this->getDoctrine()->getRepository(Animal::class)->find($id);

        $this->remove($animal);
        return $this->respond(array('Ok'));
    }
}