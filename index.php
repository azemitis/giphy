<?php declare(strict_types=1);

require_once 'vendor/autoload.php';

//use App\Controllers\GiphyController;
use Dotenv\Dotenv;
use FastRoute\RouteCollector;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\GiphyController', 'home']);
    $r->addRoute('GET', '/search/{searchTerm:.+}', ['App\Controllers\GiphyController', 'search']);
    $r->addRoute('GET', '/trending', ['App\Controllers\GiphyController', 'trending']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'rabbit';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$class, $method] = $handler;

        $apiClient = new $class();
        $loader = new FilesystemLoader('App/Views');
        $twig = new Environment($loader);

        echo $apiClient->$method($vars, $twig);
        break;
}