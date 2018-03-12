<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 02/08/2017
 * Time: 07:03
 */

namespace App\Controllers\Auth;

class AuthController
{
    protected $container;
    
    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function login()
    {
        $authenticate = $this->container->authenticate;
        $auth         = $authenticate->getin();
        
        $jwtBuilder = $this->container->jwtBuilder;
        
        $config = $this->container->config;
        
        $token = $jwtBuilder->setIssuer($config['JWT_ISSUER'])
                            ->setAudience($config['JWT_AUDIENCE'])
                            ->setId($config['JWT_ID'], true)
                            ->setIssuedAt($config['JWT_ISSUEAT'])
                            ->setNotBefore($config['JWT_NOTBEFORE'])
                            ->setExpiration($config['JWT_EXPIRATION'])// expira com 10 (dez) minutos
                            ->set('scope', $auth)
                            ->sign($this->container->jwtSigner, $config['JWT_SECRET'])
                            ->getToken();
        
        return print('Bearer ' . $token);
    }
    
    public function logout($request, $response, $args)
    {
        // your code
        // to access items in the container... $this->container->get('');
        echo 'logout';
        
        return $response;
    }
    
    public function verify()
    {
        $params = $this->container->request->getServerParams();
        
        $token = str_replace('Bearer ', '', $params['HTTP_AUTHORIZATION']);
        $token = $this->container->jwtParser->parse($token);
        
        $data = $this->container->jwtValidation;
        
        print_r($token->validate($data));
        
        return $token->validate($data);
    }
}