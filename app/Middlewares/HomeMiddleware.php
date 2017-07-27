<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 04/06/2017
 * Time: 19:22
 */

namespace Middlewares;


class HomeMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        if (!isset($_SESSION['logado'])) {
            $request = $request->withAttribute('foo', 'Deu certo');
            $response = $next($request, $response);
        } else {
            $response->getBody()->write('Logue-se primeiro');
        }
        
        return $response;
    }
}