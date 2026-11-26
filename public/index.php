<?php

declare(strict_types=1);

use App\Controller\AdminController;
use App\Controller\AuthController;
use App\Controller\TrajetController;
use App\Core\Router;
use App\Core\Session;

define('ROOT', dirname(__DIR__));

if (is_file(ROOT . '/vendor/autoload.php')) {
    require ROOT . '/vendor/autoload.php';
} else {
    spl_autoload_register(static function (string $class): void {
        if (str_starts_with($class, 'App\\')) {
            $file = ROOT . '/src/' . str_replace('\\', '/', substr($class, 4)) . '.php';
            if (is_file($file)) {
                require $file;
            }
        }
    });
}
require_once ROOT . '/src/Core/helpers.php';

Session::start();

$router = new Router();
$router->get('/', [TrajetController::class, 'index']);
$router->get('/connexion', [AuthController::class, 'loginForm']);
$router->post('/connexion', [AuthController::class, 'login']);
$router->post('/deconnexion', [AuthController::class, 'logout']);
$router->get('/trajets/creer', [TrajetController::class, 'creerForm']);
$router->post('/trajets/creer', [TrajetController::class, 'creer']);
$router->get('/trajets/{id}/modifier', [TrajetController::class, 'modifierForm']);
$router->post('/trajets/{id}/modifier', [TrajetController::class, 'modifier']);
$router->post('/trajets/{id}/supprimer', [TrajetController::class, 'supprimer']);
$router->get('/admin', [AdminController::class, 'tableau']);
$router->get('/admin/utilisateurs', [AdminController::class, 'utilisateurs']);
$router->get('/admin/agences', [AdminController::class, 'agences']);
$router->post('/admin/agences', [AdminController::class, 'agenceCreer']);
$router->post('/admin/agences/{id}/modifier', [AdminController::class, 'agenceModifier']);
$router->post('/admin/agences/{id}/supprimer', [AdminController::class, 'agenceSupprimer']);
$router->get('/admin/trajets', [AdminController::class, 'trajets']);
$router->post('/admin/trajets/{id}/supprimer', [AdminController::class, 'trajetSupprimer']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
