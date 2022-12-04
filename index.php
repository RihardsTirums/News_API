<?php
require_once "vendor/autoload.php";

use App\Controllers\ArticlesController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\LogoutController;
use App\Template;
use Dotenv\Dotenv;
use App\Database;
use App\Redirect;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$loader = new FilesystemLoader('views');
$twig = new Environment($loader);
$twig->addGlobal('session', $_SESSION);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', [ArticlesController::class, 'view']);
    $route->addRoute('GET', '/register', [RegisterController::class, 'showForm']);
    $route->addRoute('POST', '/register', [RegisterController::class, 'store']);
    $route->addRoute('GET', '/login', [LoginController::class, 'showForm']);
    $route->addRoute('POST', '/login', [LoginController::class, 'login']);
    $route->addRoute('GET', '/logout', [LogoutController::class, 'logout']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}();

        if ($response instanceof Template) {
            $userName = '';
            if (isset($_SESSION['userId'])) {
                $queryBuilder = (new Database())->getConnection()->createQueryBuilder();
                $user = $queryBuilder
                    ->select('name')
                    ->from('users')
                    ->where('id = ?')
                    ->setParameter(0, $_SESSION['userId'])->fetchAssociative();
                $userName = $user;

            }
            echo $twig->render($response->getPath(), array_merge($response->getData(), ['user' => $userName]));
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getUrl());
            exit;
        }
        break;
}

unset($_SESSION['errors']);

