<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/08/2017
 * Time: 07:01
 */

//$app->get('/login', \App\Controllers\AuthController::class . ':login');

$app->group('/auth', function () {
    $this->map(['GET', 'POST'], '/login[/{login}[/{senha}]]', \App\Controllers\AuthController::class . ':login');
    $this->map(['GET', 'POST'], '/logout', \App\Controllers\AuthController::class . ':logout');
});