<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 22/07/2017
 * Time: 13:07
*/

use Pandora\Database\DataManager;
use Entities\Auth\Users\Users;

$id = isset($_REQUEST['ipt_id']) ? $_REQUEST['ipt_id'] : '';

$users = new Users();

$users->setId($id);

$usersManager = new DataManager($conn, $users);

$op = $usersManager->disableById();

$msg  = $op['message'];
$msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';

$ret = json_encode($msg);

echo $ret;

