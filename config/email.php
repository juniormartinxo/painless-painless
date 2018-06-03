<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/06/2018
 * Time: 19:46
 */
return [
    // Informações do servidor SMTP
    'MAIL_SMTP_HOST'     => $_ENV['MAIL_SMTP_HOST'],
    'MAIL_SMTP_AUTH'     => $_ENV['MAIL_SMTP_AUTH'],
    'MAIL_SMTP_USER'     => $_ENV['MAIL_SMTP_USER'],
    'MAIL_SMTP_PASSWORD' => $_ENV['MAIL_SMTP_PASSWORD'],
    'MAIL_SMTP_SECURE'   => $_ENV['MAIL_SMTP_SECURE'],
    'MAIL_SMTP_PORT'     => $_ENV['MAIL_SMTP_PORT'],
    'MAIL_FROM'          => $_ENV['MAIL_FROM'],
    'MAIL_FROM_NAME'     => $_ENV['MAIL_FROM_NAME']
];
