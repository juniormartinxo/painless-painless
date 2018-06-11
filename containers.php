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
use Pandora\Connection\Conn;
use Pandora\Email\Send;
use Pandora\Validation\Validation;
use PHPMailer\PHPMailer\PHPMailer;

// $app está setado no arquivo "bootstrap.php"
$container = $app->getContainer();

/*
$container['config'] = function () {
    // configurações do arquivo .env
    $dotEnv = new Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
    
    $extractFilesDir = new ExtractFiles('config/');
    
    $configFiles = new Files($extractFilesDir);
    
    $config = $configFiles->load();
    
    return $config;
};
*/

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
    $conn = new Conn($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    
    return $conn;
};

$container['validation'] = function ($c) {
    $validation = new Validation();
    
    return $validation;
};

$container['sendMail'] = function ($c){
    $PHPMailer = new PHPMailer(true);
    
    $Send = new Send($PHPMailer, $c['validation']);
    
    return $Send;
};

$container['twig'] = function ($c) {
    // Twig
    $twigLoader = new Twig_Loader_Filesystem($_ENV['VIEW_PATH']);
    
    $twig = new Twig_Environment($twigLoader, [
        'cache'       => $_ENV['VIEW_CACHE'],
        'auto_reload' => true
    ]);
    
    return $twig;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $template = $c['twig']->load('errors/404.html');
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write($template->render($var));
    };
};

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        $template = $c['twig']->load('errors/405.html');
        
        return $response
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write($template->render($var));
    };
};

$container['phpErrorHandler'] = function ($c) {
    return function ($request, $response, $error) use ($c) {
        $template = $c['twig']->load('errors/500.html');
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        
        return $c['response']
            ->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write($template->render($var));
    };
};

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $template = $c['twig']->load('errors/999.html');
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        $var['error_exception']    = $exception->getMessage();
        
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($template->render($var));
    };
};