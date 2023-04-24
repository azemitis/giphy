<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Model;

class Controller
{
    private Model $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function handleSearch(?string $searchTerm): array
    {
        $gifs = [];

        if ($searchTerm !== null) {
            $gifs = $this->model->searchGifs($searchTerm);
        }

        return $gifs;
    }
}