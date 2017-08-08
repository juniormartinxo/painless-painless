<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/07/2017
 * Time: 10:44
 */

use App\Entities\Auth\Users\Users;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Pandora\Auth\Authenticate;
use Pandora\Database\DataManager;

$user = new Users();

$dm = new DataManager($ROUTE_CONN, $user);

$login = $_REQUEST['login'] ?? '';
$senha = $_REQUEST['senha'] ?? '';

$authenticate = new Authenticate($dm, $login, $senha);

$ret['msg'] = 'Login ou senha incorreto!';

$token = '';

$auth = $authenticate->getin();

$jwtBuilder = new Builder();

$signer = new Sha256();

$token = $jwtBuilder->setIssuer($ROUTE_CONFIG['JWT_ISSUER'])
                    ->setAudience($ROUTE_CONFIG['JWT_AUDIENCE'])
                    ->setId($ROUTE_CONFIG['JWT_ID'], true)
                    ->setIssuedAt($ROUTE_CONFIG['JWT_ISSUEAT'])
                    ->setNotBefore($ROUTE_CONFIG['JWT_NOTBEFORE'])
                    ->setExpiration($ROUTE_CONFIG['JWT_EXPIRATION']) // expira com 10 (dez) minutos
                    ->set('scope', $auth)
                    ->sign($signer, $ROUTE_CONFIG['JWT_SECRET'])
                    ->getToken();

echo $token;