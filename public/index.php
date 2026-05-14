<?php

if (php_sapi_name() === 'cli-server') {
    $uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . DIRECTORY_SEPARATOR . ltrim(str_replace('/', DIRECTORY_SEPARATOR, $uri), DIRECTORY_SEPARATOR);
    if (is_file($file)) {
        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mime = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
        ][$ext] ?? 'application/octet-stream';
        header('Content-Type: ' . $mime);
        readfile($file);
        exit;
    }
}

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

$router->get('/',                        fn($req, $p) => (new HomeController())->index($req, $p));
$router->get('/api/rm/character',        fn($req, $p) => (new HomeController())->apiCharacters($req, $p));
$router->get('/characters',              fn($req, $p) => (new CharacterController())->index($req, $p));
$router->get('/character/{id}',          fn($req, $p) => (new CharacterController())->show($req, $p));
$router->get('/about',                   fn($req, $p) => (new AboutController())->index($req, $p));
$router->get('/login',                   fn($req, $p) => (new AuthController())->loginForm($req, $p));
$router->post('/login',                  fn($req, $p) => (new AuthController())->login($req, $p));
$router->get('/register',                fn($req, $p) => (new AuthController())->registerForm($req, $p));
$router->post('/register',               fn($req, $p) => (new AuthController())->register($req, $p));
$router->get('/logout',                  fn($req, $p) => (new AuthController())->logout($req, $p));
$router->post('/api/characters',         fn($req, $p) => (new CharacterController())->store($req, $p));
$router->put('/api/characters/{id}',     fn($req, $p) => (new CharacterController())->update($req, $p));
$router->delete('/api/characters/{id}',  fn($req, $p) => (new CharacterController())->destroy($req, $p));

$router->dispatch($request);
