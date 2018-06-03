<?php
session_start();

/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/03/2018
 * Time: 17:00
 */

use App\Middlewares\WebMenuMiddleware;

$menus = [
    0 => ['url' => 'home', 'normal' => 'Home', 'uppercase' => 'HOME', 'status' => ''],
    1 => ['url' => 'login', 'normal' => 'Login', 'uppercase' => 'LOGIN', 'status' => '']
];


$app->any('/session/load', function ($request, $response, $args) use ($container) {
    //$container = $this->getContainer();
    print_r($container->config['PATH_WEB']);//['PATH_ROUTES'];// $_SESSION['painless']['auth'] ?? 'Não criado!';
});

$app->group('/password', function () {
    // Autentica e retorna um token JWT
    $this->map(['GET', 'POST'], '/recover', \App\Controllers\Web\WebController::class . ':password_recover');
    $this->map(['GET', 'POST'], '/new/{token}', \App\Controllers\Web\WebController::class . ':password_new');
});

$app->any('/[{page}]', \App\Controllers\Web\WebController::class . ':render')->add(new WebMenuMiddleware($menus));