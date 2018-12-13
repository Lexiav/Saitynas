<?php
namespace App\Controller;

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
        return json_decode($request->getContent(), true);
    }


}