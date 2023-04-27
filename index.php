<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Controllers\GiphyController;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiClient = new GiphyController();

$searchTerm = $_GET['search'] ?? '';

$gifs = $apiClient->handleSearch($searchTerm);

$loader = new FilesystemLoader('App/Views');
$twig = new Environment($loader);

echo $twig->render('index.twig', ['gifs' => $gifs]);

if ($_SERVER['REQUEST_URI'] === '/trending') {
    $gifs = $apiClient->handleTrending();

    echo $twig->render('trending.twig', ['gifs' => $gifs]);
    exit;
}