<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/08/2017
 * Time: 07:01
 */

//$app->get('/login', \App\Controllers\AuthController::class . ':login');

use App\Entities\Auth\Users\Users;
use Pandora\Auth\Authenticate;
use Pandora\Database\DataManager;

$container['authenticate'] = function ($c) {
    $users = new Users();
    $dm = new DataManager($c['conn'], $users);
    
    $query = $c->request->getUri()->getQuery() ?? '';
    $args  = explode('&', $query);
    
    $login = isset($args[0]) ? explode('=', $args[0]) : '';
    $pass  = isset($args[1]) ? explode('=', $args[1]) : '';
    
    return new Authenticate($dm, $login[1], $pass[1]);
};

$app->group('/auth', function () {
    // Autentica e retorna um token JWT
    $this->map(['GET', 'POST'], '/login[/{login}[/{senha}]]', \App\Controllers\Auth\AuthController::class . ':login');
    $this->map(['GET', 'POST'], '/logout', \App\Controllers\Auth\AuthController::class . ':logout');
});

// Renova o token JWT
$app->map(['GET', 'POST'], '/refresh', \App\Controllers\Auth\AuthController::class . ':refresh');