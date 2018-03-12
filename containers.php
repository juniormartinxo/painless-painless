<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2017
 * Time: 08:49
 */

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Pandora\Config\Files;
use Pandora\Connection\Conn;
use Pandora\Utils\ExtractFiles;
use Pandora\Validation\Validation;

// $app está setado no arquivo "bootstrap.php"
$container = $app->getContainer();

$container['config'] = function () {
    // configurações do arquivo .env
    $dotEnv = new Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
    
    $extractFilesDir = new ExtractFiles('config/');
    
    $configFiles = new Files($extractFilesDir);
    
    $config = $configFiles->load();
    
    return $config;
};

$container['jwt'] = function ($c) {
    return new StdClass;
};

$container['jwtBuilder'] = function ($c) {
    return new Builder();
};

$container['jwtSigner'] = function ($c) {
    return new Sha256();
};

$container['jwtValidation'] = function ($c) {
    return new ValidationData();
};

$container['jwtParser'] = function ($c) {
    return new Parser();
};

$container['conn'] = function ($c) {
    // Conexão com o banco de dados
    $conn = new Conn($c['config']['DB_NAME'], $c['config']['DB_HOST'], $c['config']['DB_USER'], $c['config']['DB_PASS']);
    
    return $conn;
};

$container['validation'] = function ($c) {
    $validation = new Validation();
    
    return $validation;
};

$container['twig'] = function ($c) {
    // Twig
    $twigLoader = new Twig_Loader_Filesystem($c['config']['VIEW_PATH']);
    
    $twig = new Twig_Environment($twigLoader, [
        'cache'       => $c['config']['VIEW_CACHE'],
        'auto_reload' => true
    ]);
    
    return $twig;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $template = $c['twig']->load('errors/404.html');
        
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write($template->render());
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $template = $c['twig']->load('errors/405.html');
        
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write($template->render());
    };
};

$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        print_r($error);
        $template = $c['twig']->load('errors/500.html');
        
        return $c['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write($template->render());
    };
};

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withStatus(500)
                             ->withHeader('Content-Type', 'text/html')
                             ->write(print_r($exception));
    };
};