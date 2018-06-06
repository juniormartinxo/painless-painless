<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2018
 * Time: 17:43
 */

namespace App\Controllers\Auth;


class PasswordController
{
    /**
     * @var \Pandora\Contracts\Database\iDataManager
     */
    private $dm;
    
    /**
     * @var
     */
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function password_recover($request, $response, $args)
    {
        $page = 'password_recover.html';
        
        $load = $this->container->twig->load($page);
        
        $vars['path_web'] = CONFIG['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
    
    public function password_new($request, $response, $args)
    {
        $page = 'errors/expired_link.html';
        
        $token = $request->getAttribute('token');
        
        $decryptToken = deKrypt('decrypt', $token);
        
        $arrToken = json_decode($decryptToken, true);
        
        $dateLink = isset($arrToken['expired']) ? new \DateTime($arrToken['expired']) : '';
        
        $dateNow = new \DateTime(date('Y-m-d H:i:s'));
        
        if (!empty($dateLink)) {
            $page = 'password_new.html';
            
            $diff = $dateLink->diff($dateNow);
            
            $horas = $diff->h + ($diff->days * 24);
            
            if ($horas >= 24) {
                $page = 'errors/expired_link.html';
            }
        }
        
        $load = $this->container->twig->load($page);
        
        $vars['path_web'] = CONFIG['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
    
    public function send_mail_recover_password($request, $response, $args)
    {
        $email = $request->getParam('email');
        
        $user = $this->container->dm_users->findByFieldsValues(['email' => $email], 1);
        
        $userId    = $user['user_id'] ?? '';
        $userName  = $user['user_name'] ?? '';
        $userFlag  = $user['user_flag'] ?? '';
        $userEmail = $user['user_email'] ?? '';
        
        $mail['box']  = $userEmail;
        $mail['name'] = $userName;
        
        $dateLink = new \DateTime(date('Y-m-d H:i:s'));
        
        $arrToken['expired'] = $dateLink->format('Y-m-d H:i:s');
        $arrToken['id']      = $userId;
        $arrToken['flag']    = $userFlag;
        $arrToken['mail']    = $userEmail;
        
        keyShuffle($arrToken);
        
        $jsonToken = json_encode($arrToken);
        
        $token = deKrypt('encrypt', $jsonToken);
        
        //$send = $this->container->sendMail->send();
        
        return $token;
    }
}