<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 23/07/2017
 * Time: 18:17
 */
include '../vendor/autoload.php';

use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

$parser = new Parser();

$token = $parser->parse($token);

$data = new ValidationData();

$data->setIssuer($_ENV['JWT_ISSUER']);
$data->setAudience($_ENV['JWT_AUDIENCE']);
$data->setId($_ENV['JWT_ID']);

$data->setCurrentTime(time() + 60); // changing the validation time to future
$data->setCurrentTime(time() + 4000); // changing the validation time to future

print_r($data);
