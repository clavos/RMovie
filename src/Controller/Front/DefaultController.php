<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route(name="app_front_default_home", path="/", methods={"GET"})
     */
    public function home()
    {
        $user = $this->getUser();
        return $this->render('Front/Default/home.html.twig', ['user' => $user]);
    }
}