<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2018
 * Time: 17:44
 */

$app->group('/password', function () {
    // Autentica e retorna um token JWT
    $this->map(['GET', 'POST'], '/recover', \App\Controllers\Auth\PasswordController::class . ':password_recover');
    $this->map(['GET', 'POST'], '/new/{token}', \App\Controllers\Auth\PasswordController::class . ':password_new');
    $this->map(['POST'], '/send', \App\Controllers\Auth\PasswordController::class . ':send_mail_recover_password');
});