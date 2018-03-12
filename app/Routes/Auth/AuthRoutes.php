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

$container['dm_users'] = function ($c) {
    $users = new Users();
    
    return new DataManager($c['conn'], $users);
};

$container['authenticate'] = function ($c) {
    $query = $c->request->getUri()->getQuery() ?? '';
    $args  = explode('&', $query);
    
    $login = isset($args[0]) ? explode('=', $args[0]) : '';
    $pass  = isset($args[1]) ? explode('=', $args[1]) : '';
    
    return new Authenticate($c['dm_users'], $login[1], $pass[1]);
};

$container['token'] = function ($c){
     $query = $c->request->getUri()->getQuery() ?? '';
    $args  = explode('&', $query);
    
    $login = isset($args[0]) ? explode('=', $args[0]) : '';
    $pass  = isset($args[1]) ? explode('=', $args[1]) : '';
    
    return new Authenticate($c['dm_users'], $login[1], $pass[1]);
};

$app->group('/auth', function () {
    $this->map(['GET', 'POST'], '/login[/{login}[/{senha}]]', \App\Controllers\Auth\AuthController::class . ':login');
    $this->map(['GET', 'POST'], '/logout', \App\Controllers\Auth\AuthController::class . ':logout');
    $this->map(['GET', 'POST'], '/verify', \App\Controllers\Auth\AuthController::class . ':verify');
});