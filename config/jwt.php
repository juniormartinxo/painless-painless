<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 07/07/2017
 * Time: 11:41
 */

return [
    // Informações de conexão com o banco de dados
    'JWT_ISSUER'     => $_ENV['JWT_ISSUER'],
    'JWT_ID'         => $_ENV['JWT_ID'],
    'JWT_SECRET'     => $_ENV['JWT_SECRET'],
    'JWT_AUDIENCE'   => $_ENV['JWT_AUDIENCE'],
    'JWT_ISSUEAT'    => time(),
    'JWT_NOTBEFORE'  => time() + 1,
    'JWT_EXPIRATION' => time() + 600
];