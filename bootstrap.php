<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/03/2017
 * Time: 06:28
 */
require 'vendor/autoload.php';

$app = new \Slim\App();

$container = $app->getContainer();

include 'containers.php';

include 'routes/web.php';

$app->run();