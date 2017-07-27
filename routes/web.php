<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2017
 * Time: 11:30
 */
use Middlewares\AuthMiddleware;
use Middlewares\HomeMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

$app->add(new \Slim\Middleware\JwtAuthentication([
    "path" => "/api", /* or ["/api", "/admin"] */
     "passthrough" => [
         "/api/token",
         "/admin/ping"
     ], // não precisa de autenticação
    "secret" => getenv("JWT_SECRET"),
    "error" => function ($request, $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    },
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    }
]));

$app->post('/auth', function (Request $request, Response $response, $arguments) {
    $conn = $this->conn;

    include $this->config['PATH_ROOT'] . '\api\auth.php';
});

$app->get("/verify", function ($request, $response, $arguments) {
    
    $authorization = $request->getHeader("Authorization");
    
    print_r(sscanf($authorization, 'Bearer %s'));
    
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
    $foo = $request->getAttribute('foo');
    $foo2 = $request->getAttribute('foo2');
    $template = $this->twig->load('index.html');
    
    return $template->render(['foo'=>$foo,'foo2'=>$foo2]);
})->add( new AuthMiddleware() )->add( new HomeMiddleware() );