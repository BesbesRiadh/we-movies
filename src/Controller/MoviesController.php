<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MoviesService;
use Symfony\Component\HttpFoundation\Request;

class MoviesController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function indexAction(MoviesService $moviesService, Request $request): Response
    {
        return $this->render('movies/index.html.twig', [
            //Récupérer les genres et les afficher 
            'genres' =>  $moviesService->getGenres(),
        ]);
    }

    /**
     * @Route("/movies", name="movies")
     */
    public function moviesAction(MoviesService $moviesService, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            //Récupérer le genre des films
            $data = $request->toArray(); 
            //Récupérer les informations des films selon le genre choisi
            $popularMovieData = $moviesService->getPopularMovieData($data['genreId']);
        }
        return $this->render('movies/movies.html.twig', [
            'data' => $popularMovieData
        ]);
    }
}
