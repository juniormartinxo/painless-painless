<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/08/2017
 * Time: 07:03
 */

namespace App\Controllers;

class AuthController
{
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function login($request, $response, $args)
    {
        $login = $args['login'];//$request->getAttribute('login');
        $senha = $args['senha'];//$request->getAttribute('senha');
        
        echo $login . ' - ' . $senha;
        
        return $response;
    }
    
    public function logout($request, $response, $args)
    {
        // your code
        // to access items in the container... $this->container->get('');
        echo 'logout';
        
        return $response;
    }
}