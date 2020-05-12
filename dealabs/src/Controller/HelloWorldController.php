<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    /**
     * @Route("/helloworld/{name}")
     */
    public function helloWorld($name){
        /*return new Response(
            '<html><body><h1>Hello</h1></body></html>'
        );*/
        return $this->render('/hello.html.twig', [
            'user_name' => $name,
        ]);
    }

}