<?php
namespace App\Controller;

use App\Entity\Cage;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;

class CageController extends AppController
{
    /**
     * @Route("/cages", methods={"GET"})
     */
    public function getAll()
    {
        $cages = $this->getDoctrine()->getRepository(Cage::class)->findAll();
        $data = [];
        /** @var  $cage */
        foreach($cages as $cage){
            $d['length'] = $cage->getLength();
            $d['height'] = $cage->getHeight();
            $d['width'] = $cage->getWidth();
            $d['type'] = $cage->getType();
            $data[] = $d;

        }

        return $this->respond($data);
    }

    /**
     * @Route("/cages", methods={"POST"})
     */
    public function create()
    {
        $request = $this->requestAll();
        if(empty($request['length']))
        {
            return $this->respondWithErrors('Length not found');
        }
        if(empty($request['height']))
        {
            return $this->respondWithErrors('Height not found');
        }
        if(empty($request['width']))
        {
            return $this->respondWithErrors('Width not found');
        }
        if(empty($request['type']))
        {
            return $this->respondWithErrors('Type not found');
        }
        $cage = new Cage();
        $cage->setLength($request['length']);
        $cage->setHeight($request['height']);
        $cage->setWidth($request['width']);
        $cage->setType($request['type']);

        $this->persist($cage);
        $this->flush();


        $data['length'] = $cage->getLength();
        $data['height'] = $cage->getHeight();
        $data['width'] = $cage->getWidth();
        $data['type'] = $cage->getType();
        return $this->respondCreated($data);
    }
    /**
     * @Route("/cage/{id}", methods={"PUT"})
     */
    public function update($id)
    {
        $request = $this->requestAll();

        if(empty($request['length']))
        {
            return $this->respondWithErrors('Length not found');
        }
        if(empty($request['height']))
        {
            return $this->respondWithErrors('Height not found');
        }
        if(empty($request['width']))
        {
            return $this->respondWithErrors('Width not found');
        }
        if(empty($request['type']))
        {
            return $this->respondWithErrors('Type not found');
        }

        /** @var Cage $cage */
        $cage = $this->getDoctrine()->getRepository(Cage::class)->find($id);

        $cage->setLength($request['length']);
        $cage->setHeight($request['height']);
        $cage->setWidth($request['width']);
        $cage->setType($request['type']);

        $this->persist($cage);
        $this->flush();

        return $this->respond(array('Ok'));

    }
    /**
     * @Route("/cages/{id}", methods={"GET"})
     */
    public function get($id)
    {
        /** @var Cage $cage */
        $cage = $this->getDoctrine()->getRepository(Cage::class)->find($id);
        if (empty($cage)) return $this->respondWithErrors('03', 'Cage not found');
        $data['length'] = $cage->getLength();
        $data['height'] = $cage->getHeight();
        $data['width'] = $cage->getWidth();
        $data['type'] = $cage->getType();
        return $this->respond($data);
    }

    /**
     * @Route("/cages/{id}", methods={"DELETE"})
     */
    public function delete($id)
    {
        $cage = $this->getDoctrine()->getRepository(Cage::class)->find($id);

        $this->remove($cage);
        return $this->respond(array('Ok'));
    }
}