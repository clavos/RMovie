<?php

namespace App\Controller\Front;

use App\Entity\Listing;
use App\Form\UserType;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController
 * @package App\Controller
 * @Route(name="app_front_security_")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $helper
     * @return Response
     */
    public function login(AuthenticationUtils $helper): Response
    {
        return $this->render('Front/Security/login.html.twig', [
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param \Swift_Mailer
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        if ($this->getUser() instanceof User) {
            return $this->redirectToRoute('app_front_default_home');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $user->setIsActive(false);
            $user->setToken(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));

            //Les listes de base
            $to_watch = new Listing();
            $to_watch->setName('À voir');
            $to_watch->setUser($user);
            $watch = new Listing();
            $watch->setName('Vu');
            $watch->setUser($user);
            //$user->addListing($watch);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Confirmation Email'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/registration.html.twig',
                        ['name' => $user->getUsername(),'token' => $user->getToken(), 'id' => $user->getId()]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->render('Front/Security/success.html.twig');
        }

        return $this->render(
            'Front/Security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
    /**
     * @Route("/validate/{id}/{token}", name="validate_email")
     * @param $id
     * @param $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateEmail($id, $token)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);
        if ($token == $user->getToken()){
            $user->setIsActive(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('app_front_security_login');
    }

}