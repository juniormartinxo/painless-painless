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
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $auth = $_SESSION[$_ENV['SESSION_NAME']]['auth'] ?? false;
        
        $request = $request->withAttribute('auth', $auth);
        
        $response = $next($request, $response);
        
        return $response;
    }
}