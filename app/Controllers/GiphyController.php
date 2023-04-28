<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Giphy;
use GuzzleHttp\Client;
use Twig\Environment;

class GiphyController
{
    private Giphy $model;
    private Client $client;

    public function __construct()
    {
        $this->model = new Giphy();
        $this->client = new Client();
    }

    public function home(array $vars, Environment $twig): string
    {
        $template = $twig->load('index.twig');

        return $template->render([
            'gifs' => [],
            'trending_clicked' => false,
        ]);
    }

    public function search(array $vars, Environment $twig): string
    {
        $url = 'https://api.giphy.com/v1/gifs/search';
        $apiKey = $_ENV['API_KEY'];
        $searchTerm = $vars['searchTerm'] ?? '';
        $query = [
            'api_key' => $apiKey,
            'q' => $searchTerm,
            'limit' => 3,
            'offset' => 0,
            'rating' => 'g',
            'lang' => 'en',
        ];

        $response = $this->client->request('GET', $url, ['query' => $query]);
        $data = json_decode($response->getBody()->getContents(), true);

        $gifs = $data['data'];

        $template = $twig->load('search.twig');

        return $template->render([
            'gifs' => $gifs,
            'trending_clicked' => false,
            'search_term' => $searchTerm,
        ]);
    }



    public function trending(array $vars, Environment $twig): string
    {
        $url = 'https://api.giphy.com/v1/gifs/trending';
        $apiKey = $_ENV['API_KEY'];
        $query = [
            'api_key' => $apiKey,
            'limit' => 3,
            'rating' => 'g',
        ];

        $response = $this->client->request('GET', $url, ['query' => $query]);
        $data = json_decode($response->getBody()->getContents(), true);
        $gifs = $data['data'];

        $template = $twig->load('trending.twig');

        return $template->render([
            'gifs' => $gifs,
            'trending_clicked' => true,
        ]);
    }
}
