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
        
        $auth = $authenticate->getin();
        
        print_r($auth);
        
        $verify = $auth['verify'] ?? false;
        
        if ($verify) {
            $jwtBuilder = $this->container->jwtBuilder;
            
            $config = $this->container->config;
            
            $token = $jwtBuilder->setIssuer($config['JWT_ISSUER'])
                                ->setAudience($config['JWT_AUDIENCE'])
                                ->setId($config['JWT_ID'], true)
                                ->setIssuedAt($config['JWT_ISSUEAT'])
                                ->setNotBefore($config['JWT_NOTBEFORE'])
                                ->setExpiration($config['JWT_EXPIRATION'])
                                ->set('scope', $auth)
                                ->sign($this->container->jwtSigner, $config['JWT_SECRET'])
                                ->getToken();
            
            return print('Bearer ' . $token);
        } else {
            return json_encode([
                'status'  => 'error',
                'message' => 'login ou senha inv&aacute;lido'
            ]);
        }
    }
    
    public function logout($request, $response, $args)
    {
        // your code
        // to access items in the container... $this->container->get('');
        
        return $response;
    }
    
    public function refresh()
    {
        $auth = $this->container->jwt->scope;
        
        $config = $this->container->config;
        
        $jwtBuilder = $this->container->jwtBuilder;
        
        $token = $jwtBuilder->setIssuer($config['JWT_ISSUER'])
                            ->setAudience($config['JWT_AUDIENCE'])
                            ->setId($config['JWT_ID'], true)
                            ->setIssuedAt($config['JWT_ISSUEAT'])
                            ->setNotBefore($config['JWT_NOTBEFORE'])
                            ->setExpiration($config['JWT_EXPIRATION'])
                            ->set('scope', $auth)
                            ->sign($this->container->jwtSigner, $config['JWT_SECRET'])
                            ->getToken();
        
        return print('Bearer ' . $token);
    }
}