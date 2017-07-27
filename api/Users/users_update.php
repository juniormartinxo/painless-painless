<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 22/07/2017
 * Time: 13:07
*/

use Pandora\Database\DataManager;
use Pandora\Validation\Validation;
use Entities\Auth\Users\Users;

$id = $_REQUEST['ipt_id'] ?? '';
$role_id = $_REQUEST['ipt_role_id'] ?? '';
$name = $_REQUEST['ipt_name'] ?? '';
$flag = isset($_REQUEST['ipt_name']) ? flag($_REQUEST['ipt_name']) : '';
$email = $_REQUEST['ipt_email'] ?? '';
$login = $_REQUEST['ipt_login'] ?? '';
$password = $_REQUEST['ipt_password'] ?? '';
$token = $_REQUEST['ipt_token'] ?? '';

$validation = new Validation();

$check = [];

$table = 'auth_users';

// Validação do campo role_id
array_push($check, $validation->isNotEmpty($role_id, 'role_id'));

// Validação do campo name
array_push($check, $validation->isNotEmpty($name, 'name'));

// Validação do campo email
array_push($check, $validation->isNotEmpty($email, 'email'));
array_push($check, $validation->isEmail($email));
array_push($check, $validation->isUniqueDiffId($conn, $table, 'user_email', $email, $id));

// Validação do campo login
array_push($check, $validation->isNotEmpty($login, 'login'));
array_push($check, $validation->isLogin($login));
array_push($check, $validation->isUniqueDiffId($conn, $table, 'user_login', $login, $id));

// Validação do campo password
array_push($check, $validation->isNotEmpty($password, 'password'));
array_push($check, $validation->isPassword($password));


$error = 0;

$msg = [];

foreach ($check as $item) {
    $error += ($item['response'] === false) ? 1 : 0;

    if (!empty($item['message'])) {
        $msg[] = $item['message'];
    }
}

if ($error < 1) {
    $users = new Users();

    $users->setId($id);
    $users->setRole_id($role_id);
    $users->setName($name);
    $users->setFlag($flag);
    $users->setEmail($email);
    $users->setLogin($login);
    $users->setPassword($password);
    $users->setToken($token);

    $usersManager = new DataManager($conn, $users);

    $op = $usersManager->update();

    $msg = $op['message'];
    $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';
}

$ret = json_encode($msg);

echo $ret;