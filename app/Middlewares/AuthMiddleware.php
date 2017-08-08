<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 04/06/2017
 * Time: 21:51
 */

namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param callable                                 $next
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (isset($_SESSION['logado'])) {
            $request = $request->withAttribute('foo2', 'Deu certo de novo');
            $response = $next($request, $response);
        } else {
            $response->getBody()->write('Logue-se primeiro');
        }
        
        return $response;
    }
}