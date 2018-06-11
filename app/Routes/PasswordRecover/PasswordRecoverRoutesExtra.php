<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 10/06/2018
 * Time: 10:06
*/

//Rotas extras :: PasswordRecover

$app->group('/password/recover', function () {
    $this->map(['GET', 'POST'], '/challenge', \App\Controllers\PasswordRecover\PasswordRecoverController::class . ':password_recover');
    $this->map(['GET', 'POST'], '/new/{token}', \App\Controllers\PasswordRecover\PasswordRecoverController::class . ':password_new');
    $this->map(['POST'], '/send', \App\Services\PasswordRecover\PasswordRecoverService::class . ':send');
});