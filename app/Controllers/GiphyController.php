<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Giphy;
use Twig\Environment;

class GiphyController
{
    private Giphy $model;

    public function __construct()
    {
        $this->model = new Giphy();
    }

    public function home(array $vars, Environment $twig): string
    {
        $searchTerm = $_GET['q'] ?? '';
        $gifs = [];

        $template = $twig->load('index.twig');

        return $template->render([
            'gifs' => $gifs,
            'trending_clicked' => false,
            'search_term' => $searchTerm,
        ]);
    }

    public function search(array $vars, Environment $twig): string
    {
        $searchTerm = $vars['searchTerm'] ?? '';
        $gifs = $this->model->getSearchGifs($searchTerm);

        $template = $twig->load('search.twig');

        return $template->render([
            'gifs' => $gifs,
            'trending_clicked' => false,
            'search_term' => $searchTerm,
        ]);
    }

    public function trending(array $vars, Environment $twig): string
    {
        $gifs = $this->model->getTrendingGifs();

        $template = $twig->load('trending.twig');

        return $template->render([
            'gifs' => $gifs,
            'trending_clicked' => true,
        ]);
    }
}
