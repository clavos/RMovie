<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('Front/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/{id}", name="user_detail", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('Front/user/show.html.twig', ['user' => $user]);
    }
}
