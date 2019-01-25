<?php
/**
 * Created by PhpStorm.
 * User: shizawa
 * Date: 2019-01-24
 * Time: 21:22
 */

namespace App\Controller\Front;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/friend")
 */
class FriendController extends Controller
{
    /**
     * @Route("/", name="friend_list", methods="GET")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('Front/friend/index.html.twig', ['friends' => $user->getFriends()]);
    }
    /**
     * @Route("/{id}", name="ask_friend", methods="GET")
     */
    public function askFriend(User $friend): Response
    {
        $user = $this->getUser();
        $new_friend = $user->addFriend($friend);
        return $this->render('Front/friend/index.html.twig', ['friends' => $user->getFriends()]);
    }

}