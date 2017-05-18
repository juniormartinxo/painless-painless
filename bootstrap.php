<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/03/2017
 * Time: 06:28
 */
require 'vendor/autoload.php';

$dotEnv = new Dotenv\Dotenv(__DIR__);
$dotEnv->load();

use Pandora\Connection\Conn;
use Pandora\Utils\ExtractFilesDir;

$config = new ExtractFilesDir('config');

$config = array_merge(include "config/database.php");

// Conexão com o banco de dados
$conn = new Conn($config['DB_NAME'], $config['DB_HOST'], $config['DB_USER'], $config['DB_PASS']);

// Twig
$loader = new Twig_Loader_Filesystem('public/views');
$twig   = new Twig_Environment($loader, [
    'cache'       => 'tmp/cache/views',
    'auto_reload' => true
]);