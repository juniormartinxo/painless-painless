<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2017
 * Time: 11:30
 */

use App\Middlewares\AuthMiddleware;
use App\Middlewares\HomeMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret"   => $container['config']['JWT_SECRET'],
    "path"     => ["/verify"],
    //"passthrough" => ["/verify", "/admin/ping", "/painless/auth"],
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    "error"    => function ($request, $response, $arguments) {
        $data["status"]  = "error";
        $data["message"] = $arguments["message"];
        
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

//echo  $container['config']['PATH_ROUTES'] . DS . 'Users' . DS . 'UsersRoutes.php';

include $container['config']['PATH_ROUTES'] . DS . 'Auth' . DS . 'AuthRoutes.php';
include $container['config']['PATH_ROUTES'] . DS . 'Users' . DS . 'UsersRoutes.php';