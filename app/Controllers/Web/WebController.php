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
        
        if (CONFIG['CONFIG_AUTHENTICATE'] === true) {
            $auth = $request->getAttribute('auth');
            
            if ($auth) {
                $page = !empty($path) ? $path : CONFIG['VIEW_HOMEPAGE'];
            } else {
                $page = 'login';
            }
        } else {
            $page = !empty($path) ? $path : CONFIG['VIEW_HOMEPAGE'];
        }
        
        $load = $this->container->twig->load($page . '.html');
        
        $vars['navigation'] = $navigation;
        $vars['path_web']   = CONFIG['PATH_WEB'];
        
        $response->getBody()->write($load->render($vars));
        
        return $response;
    }
}