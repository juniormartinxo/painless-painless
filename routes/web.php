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

include $container['config']['PATH_ROUTES'] . DS . 'AuthRoutes.php';

$app->get('/auth', function (Request $request, Response $response, $arguments) {
    $ROUTE_CONN   = $this->conn;
    $ROUTE_CONFIG = $this->config;
    
    include $this->config['PATH_ROOT'] . '\api\auth.php';
});

$app->get("/validation", function ($request, $response, $arguments) {
    include $this->config['PATH_ROOT'] . '\api\validation.php';
});

$app->get("/verify", function ($request, $response, $arguments) {
    
    //$authorization = $request->getHeader("Authorization");
    
    $decoded = $request->getAttribute('token');
    
    print_r(date('H:i:s', $this->jwt->iat) . '<br/>');
    
    print_r(date('H:i:s', $this->jwt->exp));
    
    //print_r('test');
    
    //if (in_array("delete", $this->jwt->scope)) {
    /* Code for deleting item */
    //} else {
    /* No scope so respond with 401 Unauthorized */
    //return $response->withStatus(401);
    //}
});

$app->get("/item/{id}", function ($request, $response, $arguments) {
    
    $authorization = ($request->getHeader("Authorization"));
    
    print_r(sscanf($authorization, 'Bearer %s'));
    
    //if (in_array("delete", $this->jwt->scope)) {
    /* Code for deleting item */
    //} else {
    /* No scope so respond with 401 Unauthorized */
    //return $response->withStatus(401);
    //}
});

$app->get('/', function ($request, $response, $args) {
    
    $template = $this->twig->load('index.html');
    
    return $template->render();
});

$app->get('/home', function ($request, $response, $args) {
    $foo      = $request->getAttribute('foo');
    $foo2     = $request->getAttribute('foo2');
    $template = $this->twig->load('index.html');
    
    return $template->render(['foo' => $foo, 'foo2' => $foo2]);
})->add(new AuthMiddleware())->add(new HomeMiddleware());