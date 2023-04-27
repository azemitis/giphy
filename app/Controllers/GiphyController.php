<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Giphy;
use GuzzleHttp\Client;

class GiphyController
{
    private Giphy $model;
    private Client $client;

    public function __construct()
    {
        $this->model = new Giphy();
        $this->client = new Client();
    }

    public function handleSearch(?string $searchTerm): array
    {
        $gifs = [];

        if ($searchTerm !== null) {
            $gifs = $this->model->searchGifs($searchTerm);
        }

        return $gifs;
    }

    public function handleTrending(): array
    {
        $url = 'https://api.giphy.com/v1/gifs/trending';
        $apiKey = $_ENV['API_KEY'];
        $query = [
            'api_key' => $apiKey,
            'limit' => 10,
            'rating' => 'g',
        ];

        $response = $this->client->request('GET', $url, ['query' => $query]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }
}