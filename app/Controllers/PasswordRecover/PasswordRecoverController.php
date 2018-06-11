<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 03/06/2018
 * Time: 17:43
 */

namespace App\Controllers\PasswordRecover;


class PasswordRecoverController
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
}