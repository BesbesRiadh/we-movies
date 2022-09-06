<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MoviesService
{

    private $client;
    private $params;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
        $this->api_key = $this->params->get('api_key');
    }

    public function getGenres(): array
    {

        $response = $this->client->request(
            "GET",
            'https://api.themoviedb.org/3/genre/movie/list?api_key=' . $this->api_key
        );
        return $response->toArray();
    }

    public function getPopularMovieData($genreId): array
    {

        $response = $this->client->request(
            "GET",
            'https://api.themoviedb.org/3/discover/movie?api_key=' . $this->api_key . '&sort_by=popularity.desc&include_adult=false&include_video=true&language=fr-FR&page=1&with_genres=' . $genreId
        );

        $movieInformation = $response->toArray();
        $movieId = $movieInformation['results'][0]['id'];

        $response = $this->client->request(
            "GET",
            'https://api.themoviedb.org/3/movie/'. $movieId .'/videos?api_key='. $this->api_key .'&language=fr-FR'
        );
        $movieMedia = $response->toArray();

        $data = array(
            "title" => $movieInformation['results'][0]['title'],
            "overview" => $movieInformation['results'][0]['overview'],
            "video_name" => $movieMedia['results'][0]['name'],
            "video_url" => "https://www.youtube.com/embed/" . $movieMedia['results'][0]['key'],
            "movies_list" => $movieInformation['results']
        );

        return $data;
    }
}
