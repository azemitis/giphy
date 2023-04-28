<?php declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;

class Giphy
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getSearchGifs(string $searchTerm): array
    {
        $url = 'https://api.giphy.com/v1/gifs/search';
        $apiKey = $_ENV['API_KEY'];
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

        return $data['data'];
    }

    public function getTrendingGifs(): array
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

        return $data['data'];
    }
}