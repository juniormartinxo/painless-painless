<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/03/2018
 * Time: 17:00
 */

use App\Middlewares\WebMenuMiddleware;

$menus = [
    0 => ['url' => 'home', 'normal' => 'Home', 'uppercase' => 'HOME', 'status' => ''],
    1 => ['url' => 'contato', 'normal' => 'Contato', 'uppercase' => 'CONTATO', 'status' => '']
];

$app->any('/[{page}]', \App\Controllers\Web\WebController::class . ':render')->add(new WebMenuMiddleware($menus));