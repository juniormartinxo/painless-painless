<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/03/2017
 * Time: 06:28
 */
require 'vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);

$app = new \Slim\App();

// Containers
include 'containers.php';

// Routes
include 'routes/auth.php';
include 'routes/app.php';
include 'routes/api.php';
include 'routes/web.php';

$app->run();