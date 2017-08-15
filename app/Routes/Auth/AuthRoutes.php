<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/08/2017
 * Time: 07:01
 */

//$app->get('/login', \App\Controllers\AuthController::class . ':login');

use App\Entities\Auth\Users\Users;
use Pandora\Database\DataManager;

$container['dm'] = function ($c) {
    $users = new Users();
    return new DataManager($c['conn'], $users);
};

$app->group('/auth', function () {
    $this->map(['GET', 'POST'], '/login[/{login}[/{senha}]]', \App\Controllers\Auth\AuthController::class . ':login');
    $this->map(['GET', 'POST'], '/logout', \App\Controllers\Auth\AuthController::class . ':logout');
});