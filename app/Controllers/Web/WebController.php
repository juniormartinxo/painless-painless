<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 30/03/2018
 * Time: 16:59
 */

namespace App\Controllers\Web;


class WebController
{
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function render($request, $response, $args)
    {
        $navigation = $request->getAttribute('navigation');
        $path       = $request->getAttribute('path');
        
        $page = !empty($path) ? $path : 'index';
        
        $load = $this->container->twig->load($page . '.html');
        
        $vars['navigation'] = $navigation;
        $vars['path_web']   = $this->container->config['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
    
    public function password_recover($request, $response, $args)
    {
        $page = 'password_recover';
        
        $load = $this->container->twig->load($page . '.html');
        
        $vars['path_web'] = $this->container->config['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
    
    public function password_new($request, $response, $args)
    {
        $page = 'password_new';
        
        $token = $request->getAttribute('token');
        
        $load = $this->container->twig->load($page . '.html');
        
        $vars['path_web'] = $this->container->config['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
}