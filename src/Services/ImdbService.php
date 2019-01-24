<?php
/**
 * Created by IntelliJ IDEA.
 * User: clavo
 * Date: 23/01/2019
 * Time: 22:00
 */

namespace App\Services;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class ImdbService
{
    private $imdbClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $imdbClient, Serializer $serializer)
    {
        $this->$imdbClient = $imdbClient;
        $this->serializer = $serializer;
        $this->apiKey = '9ab4d92b';
    }

    public function searchFilmByTitle($title)
    {
        $uri = '/?apikey='.$this->apiKey.'&t='.$title;
        $response = $this->imdbClient->get($uri);

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return [
            'Title' => $data['Title'],
            'Year' => $data['Plot']
        ];
    }

}