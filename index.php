<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Controllers\Controller;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiClient = new Controller();

$searchTerm = $_GET['search'] ?? '';

$gifs = $apiClient->handleSearch($searchTerm);

require_once 'App/Views/index.php';