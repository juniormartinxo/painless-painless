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
use Pandora\Email\Templates;
use Pandora\Http\Requisitions;
use Pandora\Validation\Validation;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use UserAgentParser\Provider\PiwikDeviceDetector;

// $app está setado no arquivo "bootstrap.php"
$container = $app->getContainer();

$container['jwt'] = function () {
    return new StdClass;
};

$container['jwtBuilder'] = function () {
    return new Builder();
};

$container['jwtSigner'] = function () {
    return new Sha256();
};

$container['jwtValidation'] = function () {
    return new ValidationData();
};

$container['jwtParser'] = function () {
    return new Parser();
};

$container['conn'] = function () {
    // Conexão com o banco de dados
    return new Conn($_ENV['DB_NAME'], $_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
};

$container['requisitions'] = function () {
    return new Requisitions();
};

$container['userAgentParser'] = function () {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    $provider = new PiwikDeviceDetector();
    
    return $provider->parse($userAgent);
};

$container['validation'] = function () {
    return new Validation();
};

$container['sendMail'] = function () {
    $PHPMailer  = new PHPMailer(true);
    $validation = new Validation();
    
    return new Send($PHPMailer, $validation);
};

$container['templateMail'] = function () {
    return new Templates(CONFIG['PATH_ROOT'] . CONFIG['MAIL_TEMPLATE_PATH']);
};

$container['twig'] = function () {
    // Twig
    $twigLoader = new Twig\Loader\FilesystemLoader($_ENV['VIEW_PATH']);
    
    return new Twig\Environment($twigLoader, [
        'cache'       => $_ENV['VIEW_CACHE'],
        'auto_reload' => true
    ]);
};

$container['notFoundHandler'] = function (Container $c) {
    return function (Response $response) use ($c) {
        $template = 'errors/404.html';
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        
        return $response->withStatus(404)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($c['twig']->load($template)->render($var));
    };
};

$container['notAllowedHandler'] = function (Container $c) {
    return function (Response $response, array $methods) use ($c) {
        $template = 'errors/405.html';
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        
        return $response->withStatus(405)
                        ->withHeader('Allow', implode(', ', $methods))
                        ->withHeader('Content-type', 'text/html')
                        ->write($c['twig']->load($template)->render($var));
    };
};

$container['phpErrorHandler'] = function (Container $c) {
    return function (Request $request, Response $response) use ($c) {
        $template = 'errors/500.html';
        
        $var['path_web'] = CONFIG['PATH_WEB'];
        
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($c['twig']->load($template)->render($var));
    };
};

$container['errorHandler'] = function (Container $c) {
    return function (Response $response, Exception $exception) use ($c) {
        $template = 'errors/999.html';
        
        $var['path_web']        = CONFIG['PATH_WEB'];
        $var['error_exception'] = $exception->getMessage();
        
        return $response->withStatus(500)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($c['twig']->load($template)->render($var));
    };
};