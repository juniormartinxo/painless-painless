<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/06/2018
 * Time: 17:32
 */

namespace App\Services\PasswordRecover;


use Slim\Http\Request;

class PasswordRecoverService
{
    /**
     * @var
     */
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    /**
     * @param \Slim\Http\Request $request
     *
     * @return mixed
     */
    public function send(Request $request)
    {
        $email = $request->getParam('email');
        
        $user = $this->container->dm_users->findByFieldsValues(['email' => $email], 1);
        
        $userId   = $user['user_id'] ?? '';
        $userName = $user['user_name'] ?? '';
        
        //$userFlag  = $user['user_flag'] ?? '';
        //$userEmail = $user['user_email'] ?? '';
        
        $mail['box']  = $email;
        $mail['name'] = $userName;
        
        $dateLink = new \DateTime(date('Y-m-d H:i:s'));
        
        $arrToken['expired'] = $dateLink->format('Y-m-d H:i:s');
        $arrToken['id']      = $userId;
        
        //$arrToken['flag'] = $userFlag;
        //$arrToken['mail'] = $userEmail;
        
        keyShuffle($arrToken);
        
        $jsonToken = json_encode($arrToken);
        
        $token = deKrypt('encrypt', $jsonToken);
        
        $subject = $_ENV['APP_NAME'] . utf8_decode(' - Recuperação de senha');
        
        $bodyHtml = 'Olá ' . $userName . '! <br/>';
        $bodyHtml .= 'Você está recebendo essa mensagem porque uma solicitação de recuperação de senha foi feito no ' . $_ENV['APP_NAME'] . '<br/><br/>';
        $bodyHtml .= 'Clique no link abaixo ou copie o link e cole no navegador para informar sua nova senha:<br/>';
        $bodyHtml .= CONFIG['PATH_WEB'] . '/password/recover/new/' . $token . '<br/><br/>';
        $bodyHtml .= 'Atenciosamente, Equipe ' . $_ENV['APP_NAME'];
        
        $bodyNoHtml = $bodyHtml;
        
        $messageSuccess = 'Email enviado com sucesso!';
        
        $send = $this->container->sendMail->simple($mail, $subject, $bodyHtml, $bodyNoHtml, $messageSuccess);
        
        return $send;
    }
}