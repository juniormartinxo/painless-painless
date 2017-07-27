<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 22/07/2017
 * Time: 10:44
 */

use Entities\Auth\Users\Users;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Pandora\Auth\Authenticate;
use Pandora\Database\DataManager;

$user = new Users();

$dm = new DataManager($conn, $user);

$login = $_REQUEST['login'] ?? '';
$senha = $_REQUEST['senha'] ?? '';

$authenticate = new Authenticate($dm, $login, $senha);

$ret['msg'] = 'Login ou senha incorreto!';

$token = '';

$auth = $authenticate->getin();

$jwtBuilder = new Builder();

$signer = new Sha256();

$token = $jwtBuilder->setIssuer($_ENV['JWT_ISSUER'])
                    ->setAudience($_ENV['JWT_AUDIENCE'])
                    ->setId($_ENV['JWT_ID'], true)
                    ->setIssuedAt(time())
                    ->setNotBefore(time() + 60)
                    ->setExpiration(time() + 3600)
                    ->set('scope', $auth)
                    ->sign($signer, $_ENV['JWT_SECRET'])
                    ->getToken();

echo $token;