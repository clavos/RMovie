<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route(name="app_back_default_home", path="/", methods={"GET"})
     */
    public function home()
    {
        return $this->render('Back/Default/home.html.twig');
    }
}