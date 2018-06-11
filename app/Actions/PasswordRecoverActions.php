<?php
/**
 * Created by Invoker.
 * Author: Aluisio Martins Junior <junior@mjpsolucoes.com.br>
 * Date: 10/06/2018
 * Time: 12:06
*/

namespace App\Actions;

use Pandora\Contracts\Actions\iActions;
use Pandora\Contracts\Connection\iConn;
use Pandora\Contracts\Database\iDataManager;
use Pandora\Contracts\Validation\iValidation;
use App\Entities\Auth\PasswordRecover\PasswordRecover;
use Slim\Container;

class PasswordRecoverActions implements iActions
{
    /**
     * @var \Pandora\Contracts\Connection\iConn
     */
    private $conn;

    /**
     * @var \Pandora\Contracts\Database\iDataManager
     */
    private $dm;

    /**
     * @var \Pandora\Contracts\Validation\iValidation
     */
    private $validation;

    /**
     * @var \App\Entities\Auth\PasswordRecover\PasswordRecover
     */
    private $passwordRecover;

    /**
     * @var string
     */
    private $table = 'auth_password_recover';
    
    /**
     * PasswordRecoverActions constructor.
     *
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->setValidation($container['validation']);
        $this->setDm($container['dm_passwordRecover']);
        $this->setConn($container['conn']);
        $this->setPasswordRecover($this->dm->getObject());
    }

    /**
     *
     * @return string
     */
    public function insert()
    {
        $id            = $_REQUEST['ipt_id'] ?? '';
        $user_id       = $_REQUEST['ipt_user_id'] ?? '';
        $email         = $_REQUEST['ipt_email'] ?? '';
        $ip            = $_REQUEST['ipt_ip'] ?? '';
        $device        = $_REQUEST['ipt_device'] ?? '';
        $date_request  = date('Y-m-d H:i:s');
        $date_update   = $_REQUEST['ipt_date_update'] ?? '';
        $token         = $_REQUEST['ipt_token'] ?? '';
        $condition     = $_REQUEST['ipt_condition'] ?? 'A';

        $validation = $this->getValidation();

        $check = [];

        // Validação do campo user_id
        array_push($check, $validation->isNotEmpty($user_id, 'ID do usuÃ¡rio'));

        // Validação do campo email
        array_push($check, $validation->isNotEmpty($email, 'Email'));
        array_push($check, $validation->isEmail($email));

        // Validação do campo ip
        array_push($check, $validation->isNotEmpty($ip, 'IP do usuÃ¡rio'));
        array_push($check, $validation->isIp($ip));

        // Validação do campo device
        array_push($check, $validation->isNotEmpty($device, 'Dispositivo'));

        // Validação do campo date_request
        array_push($check, $validation->isNotEmpty($date_request, 'Data da solicitaÃ§Ã£o'));

        // Validação do campo date_update
        array_push($check, $validation->isNotEmpty($date_update, 'AtualizaÃ§Ã£o'));

        // Validação do campo token
        array_push($check, $validation->isNotEmpty($token, 'Token'));

        // Validação do campo condition
        array_push($check, $validation->isNotEmpty($condition, 'SituaÃ§Ã£o'));

        $error = 0;

        $msg = [];

        foreach ($check as $item) {
            $error += ($item['response'] === false) ? 1 : 0;

            if (!empty($item['message'])) {
                $msg[] = $item['message'];
            }
        }

        if ($error < 1) {
            $passwordRecover = $this->getPasswordRecover();

            $passwordRecover->setId($id);
            $passwordRecover->setUser_id($user_id);
            $passwordRecover->setEmail($email);
            $passwordRecover->setIp($ip);
            $passwordRecover->setDevice($device);
            $passwordRecover->setDate_request($date_request);
            $passwordRecover->setDate_update($date_update);
            $passwordRecover->setToken($token);
            $passwordRecover->setCondition($condition);

            $dm = $this->getDm();
            $dm->setObject($passwordRecover);

            $op = $dm->insert();

            $msg = $op['message'];
            $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';
        }

        return json_encode($msg);
    }

    /**
     *
     * @return string
     */
    public function update()
    {
        $user_id       = $_REQUEST['ipt_user_id'] ?? '';
        $email         = $_REQUEST['ipt_email'] ?? '';
        $ip            = $_REQUEST['ipt_ip'] ?? '';
        $device        = $_REQUEST['ipt_device'] ?? '';
        $date_request  = date('Y-m-d H:i:s');
        $date_update   = $_REQUEST['ipt_date_update'] ?? '';
        $token         = $_REQUEST['ipt_token'] ?? '';
        $condition     = $_REQUEST['ipt_condition'] ?? 'A';

        $validation = $this->getValidation();

        $check = [];

        // Validação do campo email
        array_push($check, $validation->isNotEmpty($email, 'Email'));
        array_push($check, $validation->isEmail($email));

        // Validação do campo ip
        array_push($check, $validation->isNotEmpty($ip, 'IP do usuÃ¡rio'));
        array_push($check, $validation->isIp($ip));

        // Validação do campo device
        array_push($check, $validation->isNotEmpty($device, 'Dispositivo'));

        // Validação do campo date_request
        array_push($check, $validation->isNotEmpty($date_request, 'Data da solicitaÃ§Ã£o'));

        // Validação do campo date_update
        array_push($check, $validation->isNotEmpty($date_update, 'AtualizaÃ§Ã£o'));

        // Validação do campo token
        array_push($check, $validation->isNotEmpty($token, 'Token'));

        // Validação do campo condition
        array_push($check, $validation->isNotEmpty($condition, 'SituaÃ§Ã£o'));

        $error = 0;

        $msg = [];

        foreach ($check as $item) {
            $error += ($item['response'] === false) ? 1 : 0;

            if (!empty($item['message'])) {
                $msg[] = $item['message'];
            }
        }

        if ($error < 1) {
            $passwordRecover = $this->getPasswordRecover();

            $passwordRecover->setId($id);
            $passwordRecover->setId($id);
            $passwordRecover->setUser_id($user_id);
            $passwordRecover->setEmail($email);
            $passwordRecover->setIp($ip);
            $passwordRecover->setDevice($device);
            $passwordRecover->setDate_request($date_request);
            $passwordRecover->setDate_update($date_update);
            $passwordRecover->setToken($token);
            $passwordRecover->setCondition($condition);

            $dm = $this->getDm();

            $dm->setObject($passwordRecover);

            $op = $dm->update();

            $msg = $op['message'];
            $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';
        }

        return json_encode($msg);
    }

    /**
     *
     * @return string
     */
    public function disable()
    {
        $id = $_REQUEST['ipt_id'] ?? '';

        $passwordRecover = $this->getPasswordRecover();
        $passwordRecover->setId($id);

        $dm = $this->getDm();
        $dm->setObject($passwordRecover);

        $op = $dm->disableById();

        $msg = $op['message'];
        $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';

        return json_encode($msg);
    }

    /**
     *
     * @return string
     */
    public function enable()
    {
        $id = $_REQUEST['ipt_id'] ?? '';

        $passwordRecover = $this->getPasswordRecover();
        $passwordRecover->setId($id);

        $dm = $this->getDm();
        $dm->setObject($passwordRecover);

        $op = $dm->enableById();

        $msg = $op['message'];
        $msg .= !empty($op['error_info']) ? ' :: ' . $op['error_info'] : '';

        return json_encode($msg);
    }

    /**
     * @param \Pandora\Contracts\Connection\iConn $conn
     *
     * @return $this
     */
    private function setConn(iConn $conn)
    {
        $this->conn = $conn;

        return $this;
    }

    /**
     * @return mixed
     */private function getDm()
    {
        return $this->dm;
    }

    /**
     * @param \Pandora\Contracts\Database\iDataManager $dm
     *
     * @return $this
     */
    private function setDm(iDataManager $dm)
    {
        $this->dm = $dm;

        return $this;
    }

    /**
     * @return \APP\Entities\Auth\PasswordRecover\passwordRecover
     */
    private function getPasswordRecover(): PasswordRecover
    {
        return $this->passwordRecover;
    }

    /**
     * @param mixed $passwordRecover
     *
     * @return PasswordRecoverActions
     */
    private function setPasswordRecover($passwordRecover)
    {
        $this->passwordRecover = $passwordRecover;

        return $this;
    }

    /**
     * @return mixed
     */
    private function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param \Pandora\Contracts\Validation\iValidation $validation
     *
     * @return $this
    */
    private function setValidation(iValidation $validation)
    {
        $this->validation = $validation;

        return $this;
    }
}