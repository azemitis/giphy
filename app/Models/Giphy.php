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

    public function searchGifs(string $searchTerm): array
    {
        $url = 'https://api.giphy.com/v1/gifs/search';
        $apiKey = $_ENV['API_KEY'];
        $query = [
            'api_key' => $apiKey,
            'q' => $searchTerm,
            'limit' => 25,
            'offset' => 0,
            'rating' => 'g',
            'lang' => 'en',
        ];

        $response = $this->client->request('GET', $url, ['query' => $query]);
        $data = json_decode($response->getBody()->getContents(), true);

        return $data['data'];
    }
}