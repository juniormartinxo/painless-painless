<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/06/2018
 * Time: 10:44
 */

namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class AuthMiddleware
{
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param callable                                 $next
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $path = $request->getUri()->getPath();
        
        $menus = $this->menus;
        
        foreach ($menus as $k => $menu) {
            $menus[$k]['status']    = $menu['url'] == $path ? 'selected' : '';
        }
        
        switch ($path) {
            case '/':
                $menus[0]['status'] = 'selected';
                $page               = 'index';
                break;
            
            case 'home':
                $page = 'index';
                break;
            
            default:
                $page = $path;
            
        }
        
        $request = $request->withAttribute('navigation', $menus);
        $request = $request->withAttribute('path', $page);
        
        $response = $next($request, $response);
        
        return $response;
    }
}