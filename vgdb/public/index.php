<?php

session_start();

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function (string $class): void {
    $paths = [
        BASE_PATH . '/app/Core/' . $class . '.php',
        BASE_PATH . '/app/Controllers/' . $class . '.php',
        BASE_PATH . '/app/Models/' . $class . '.php',
        BASE_PATH . '/app/Helpers/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

require BASE_PATH . '/app/Helpers/functions.php';

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

$router->get('/videogames', [VideoGameController::class, 'index']);
$router->get('/videogames/{id}', [VideoGameController::class, 'show']);

$router->get('/jogos', [JogoController::class, 'index']);
$router->get('/jogos/{id}', [JogoController::class, 'show']);

$router->get('/admin', [AdminController::class, 'dashboard']);

$router->get('/admin/videogames', [VideoGameController::class, 'adminIndex']);
$router->get('/admin/videogames/novo', [VideoGameController::class, 'create']);
$router->post('/admin/videogames/salvar', [VideoGameController::class, 'store']);
$router->get('/admin/videogames/{id}/editar', [VideoGameController::class, 'edit']);
$router->post('/admin/videogames/{id}/atualizar', [VideoGameController::class, 'update']);
$router->post('/admin/videogames/{id}/excluir', [VideoGameController::class, 'destroy']);

$router->get('/admin/jogos', [JogoController::class, 'adminIndex']);
$router->get('/admin/jogos/novo', [JogoController::class, 'create']);
$router->post('/admin/jogos/salvar', [JogoController::class, 'store']);
$router->get('/admin/jogos/{id}/editar', [JogoController::class, 'edit']);
$router->post('/admin/jogos/{id}/atualizar', [JogoController::class, 'update']);
$router->post('/admin/jogos/{id}/excluir', [JogoController::class, 'destroy']);

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (PDOException $exception) {
    http_response_code(500);
    (new HomeController())->databaseError($exception);
}
