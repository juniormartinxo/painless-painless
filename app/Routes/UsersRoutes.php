<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 22/07/2017
 * Time: 12:07
*/

$app->post('/user', function (Request $request, Response $response, $arguments) {
    $conn = $this->conn;

    include $this->config['PATH_ROOT'] . '\api\Users\users_insert.php';
});

$app->put('/user/{id}', function (Request $request, Response $response, $arguments) {
    $conn = $this->conn;

    include $this->config['PATH_ROOT'] . '\api\Users\users_update.php';
});

$app->patch('/user/{id}', function (Request $request, Response $response, $arguments) {
    $conn = $this->conn;

    include $this->config['PATH_ROOT'] . '\api\Users\users_enable.php';
});

$app->delete('/user/{id}', function (Request $request, Response $response, $arguments) {
    $conn = $this->conn;

    include $this->config['PATH_ROOT'] . '\api\Users\users_disable.php';
});

include 'UsersRoutesExtra.php';