<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 11/03/2018
 * Time: 08:48
 * @see https://medium.com/@fidelissauro/slim-framework-criando-microservices-07-implementando-seguran%C3%A7a-b%C3%A1sica-com-http-auth-e-proxy-ed6dd6d517f4
 */

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secret"      => $container['config']['JWT_SECRET'],
    // Cobertura da autenticação, no caso de "/" protege todos os links
    "path"        => ["/"],
    // Links livres da verificação da autenticação
    "passthrough" => ["/auth"],
    // Se tudo der certo dispara o callback
    "callback"    => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    // Se der errado dispara o erro
    "error"       => function ($request, $response, $arguments) {
        $data["status"]  = "error";
        $data["message"] = $arguments["message"];
        
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

include $container['config']['PATH_ROUTES'] . DS . 'Auth' . DS . 'AuthRoutes.php';