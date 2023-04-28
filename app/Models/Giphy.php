<?php declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;
use FastRoute\RouteCollector;

class Giphy
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

//    public function registerRoutes(RouteCollector $router): void
//    {
//        $router->get('/search/{searchTerm}', function (array $params) {
//            $searchTerm = $params['searchTerm'];
//            $gifs = $this->searchGifs($searchTerm);
//
//            $loader = new FilesystemLoader('App/Views');
//            $twig = new Environment($loader);
//
//            echo $twig->render('index.twig', ['gifs' => $gifs]);
//        });
//    }
}
