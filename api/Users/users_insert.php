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

$role_id = $_REQUEST['ipt_role_id'] ?? '';
$name = $_REQUEST['ipt_name'] ?? '';
$flag = isset($_REQUEST['ipt_name']) ? flag($_REQUEST['ipt_name']) : '';
$email = $_REQUEST['ipt_email'] ?? '';
$login = $_REQUEST['ipt_login'] ?? '';
$password = isset($_REQUEST['ipt_password']) ? password($_REQUEST['ipt_password']) : '';
$token = isset($_REQUEST['ipt_email']) ? token_user('email', $_REQUEST['ipt_email']) : '';

$validation = new Validation();

$check = [];

$table = 'auth_users';

// Validação do campo role_id
array_push($check, $validation->isNotEmpty($role_id, 'err'));

// Validação do campo name
array_push($check, $validation->isNotEmpty($name, 'err'));

// Validação do campo email
array_push($check, $validation->isNotEmpty($email, 'err'));
array_push($check, $validation->isEmail($email));
array_push($check, $validation->isUnique($conn, $table, 'user_email', $email));

// Validação do campo login
array_push($check, $validation->isNotEmpty($login, 'err'));
array_push($check, $validation->isLogin($login));
array_push($check, $validation->isUnique($conn, $table, 'user_login', $login));

// Validação do campo password
array_push($check, $validation->isNotEmpty($password, 'err'));
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

    $users->setRole_id($role_id);
    $users->setName($name);
    $users->setFlag($flag);
    $users->setEmail($email);
    $users->setLogin($login);
    $users->setPassword($password);
    $users->setToken($token);

    $usersManager = new DataManager($conn, $users);

    $fields = [
        'user_role_id' => $users->getRole_id(),
        'user_name' => $users->getName(),
        'user_flag' => $users->getFlag(),
        'user_email' => $users->getEmail(),
        'user_login' => $users->getLogin(),
        'user_password' => $users->getPassword(),
        'user_token' => $users->getToken(),
    ];

    $op = $usersManager->insert($fields);

    $msg = $op['message'];
    $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';
}

$ret = json_encode($msg);

echo $ret;