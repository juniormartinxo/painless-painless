<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2018
 * Time: 08:48
 */

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret"   => $container['config']['JWT_SECRET'],
    "path"     => ["/auth/verify"],
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

include $container['config']['PATH_ROUTES'] . DS . 'Auth' . DS . 'AuthRoutes.php';