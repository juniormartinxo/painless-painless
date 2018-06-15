<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/06/2018
 * Time: 17:32
 */

namespace App\Services\PasswordRecover;


use Slim\Container;
use Slim\Http\Request;

class PasswordRecoverService
{
    /**
     * @var \Slim\Container
     */
    protected $container;
    /**
     * @var \Pandora\Database\DataManager
     */
    private $dataManager;
    /**
     * @var \App\Actions\PasswordRecoverActions
     */
    private $passwordRecoverActions;
    /**
     * @var \Pandora\Email\Send
     */
    private $sendMail;
    
    /**
     * @var \UserAgentParser\Provider\PiwikDeviceDetector
     */
    private $userAgentParser;
    
    /**
     * PasswordRecoverService constructor.
     *
     * @param \Slim\Container $container
     *
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        
        $this->passwordRecoverActions = $container->get('passwordRecoverActions');
        
        $this->sendMail = $container->get('sendMail');
        
        $this->dataManager = $container->get('dm_users');
        
        $this->userAgentParser = $container->get('userAgentParser');
    }
    
    /**
     * @param \Slim\Http\Request $request
     *
     * @return mixed
     */
    public function send(Request $request)
    {
        $email = $request->getParam('email');
        
        $user = $this->dataManager->findByFieldsValues(['email' => $email], 1);
        
        $userId   = $user['user_id'] ?? '';
        $userName = $user['user_name'] ?? '';
        
        $mail['box']  = $email;
        $mail['name'] = $userName;
        
        $dateLink = new \DateTime(date('Y-m-d H:i:s'));
        
        $arrToken['exp'] = $dateLink->format('Y-m-d H:i:s');
        $arrToken['id']  = $userId;
        
        keyShuffle($arrToken);
        
        $jsonToken = json_encode($arrToken);
        
        $token = krypt('encrypt', $jsonToken);
        
        $subject = $_ENV['APP_NAME'] . utf8_decode(' - Recuperação de senha');
        
        $bodyHtml = 'Olá ' . $userName . '! <br/>';
        $bodyHtml .= 'Você está recebendo essa mensagem porque uma solicitação de recuperação de senha foi feito no ' . $_ENV['APP_NAME'] . '<br/><br/>';
        $bodyHtml .= 'Clique no link abaixo ou copie o link e cole no navegador para informar sua nova senha:<br/>';
        $bodyHtml .= CONFIG['PATH_WEB'] . '/password/recover/new/' . $token . '<br/><br/>';
        $bodyHtml .= 'Atenciosamente, Equipe ' . $_ENV['APP_NAME'];
        
        $bodyNoHtml = $bodyHtml;
        
        $send = $this->sendMail->simple($mail, $subject, $bodyHtml, $bodyNoHtml);
        
        if ($send[0]) {
            $fields['ipt_user_id'] = $userId;
            $fields['ipt_email']   = $email;
            $fields['ipt_ip']      = $_SERVER["REMOTE_ADDR"];
            $fields['ipt_device']  = $this->device();
            $fields['ipt_token']   = $token;
            
            $this->passwordRecoverActions->insert($fields);
        }
        
        return $send[1] ?? 'Erro ao tentar enviar...';
    }
    
    private function device()
    {
        $str = $this->userAgentParser->getDevice()->getType();
        
        if(!empty($this->userAgentParser->getDevice()->getBrand())){
            $str .= ', ' . $this->userAgentParser->getDevice()->getBrand();
        }
        
        if(!empty($this->userAgentParser->getDevice()->getModel())){
            $str .= ' - ' . $this->userAgentParser->getDevice()->getModel();
        }
        
        return $str;
    }
}