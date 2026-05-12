<?php

require dirname(__DIR__) . '/bootstrap.php';

use App\Infrastructure\Database;
use App\Presentation\Request;
use App\Presentation\Router;
use App\Presentation\Controllers\HomeController;
use App\Presentation\Controllers\CharacterController;
use App\Presentation\Controllers\AuthController;
use App\Presentation\Controllers\AboutController;

Database::migrate();

$router  = new Router();
$request = new Request();

$router->get('/',                       fn($req, $p) => (new HomeController())->index($req, $p));
$router->get('/characters',             fn($req, $p) => (new CharacterController())->index($req, $p));
$router->get('/character/{id}',         fn($req, $p) => (new CharacterController())->show($req, $p));
$router->get('/about',                  fn($req, $p) => (new AboutController())->index($req, $p));
$router->get('/login',                  fn($req, $p) => (new AuthController())->loginForm($req, $p));
$router->post('/login',                 fn($req, $p) => (new AuthController())->login($req, $p));
$router->get('/register',               fn($req, $p) => (new AuthController())->registerForm($req, $p));
$router->post('/register',              fn($req, $p) => (new AuthController())->register($req, $p));
$router->get('/logout',                 fn($req, $p) => (new AuthController())->logout($req, $p));
$router->post('/api/characters',        fn($req, $p) => (new CharacterController())->store($req, $p));
$router->put('/api/characters/{id}',    fn($req, $p) => (new CharacterController())->update($req, $p));
$router->delete('/api/characters/{id}', fn($req, $p) => (new CharacterController())->destroy($req, $p));

$router->dispatch($request);
