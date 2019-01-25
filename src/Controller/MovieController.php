<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Comment;
use App\Form\Movie1Type;
use App\Form\CommentType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ImdbService; 

/**
 * @Route("/movie")
 */
class MovieController extends AbstractController
{
    // private $imdb; 

    // public function __construct(ImdbService $imdb){
    //     $this->imdb = $imdb;
    // }

    /**
     * @Route("/", name="movie_index", methods="GET")
     */
    public function index(MovieRepository $movieRepository): Response
    {
        // $this->imdb->searchFilmByTitle('The Godfather');

        return $this->render('movie/index.html.twig', ['movies' => $movieRepository->findAll()]);
    }

    /**
     * @Route("/new", name="movie_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(Movie1Type::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();

            return $this->redirectToRoute('movie_index');
        }

        return $this->render('movie/new.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_show", methods="GET")
     */
    public function show(Movie $movie): Response
    {
        $list_comments = $movie->getComments(); 
        return $this->render('movie/show.html.twig', [
            'movie' => $movie, 
            'list_comments' => $list_comments,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movie_edit", methods="GET|POST")
     */
    public function edit(Request $request, Movie $movie): Response
    {
        $form = $this->createForm(Movie1Type::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movie_edit', ['id' => $movie->getId()]);
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_delete", methods="DELETE")
     */
    public function delete(Request $request, Movie $movie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movie->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($movie);
            $em->flush();
        }

        return $this->redirectToRoute('movie_index');
    }


    /**
     * @Route("/add_comment", name="add_comment", methods={"GET","POST"})
     */
    public function add_comment(Request $request, int $movie): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('movie_show/$movie');
        }

        $list_comments = $movie->getComments();
        return $this->render('movie/show.html.twig', [
            'movie' => $movie, 
            'list_comments' => $list_comments,
        ]);
    }
}
