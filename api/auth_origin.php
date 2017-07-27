<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 09/07/2016
 * Time: 21:17
 * https://github.com/lcobucci/jwt
 * https://tools.ietf.org/html/rfc7519#section-4.1.5
 */
use Classes\UserAuth;
use Classes\UserTipo;
use Lcobucci\JWT\Configuration;

$userLogin = isset($_REQUEST['login']) ? $_REQUEST['login'] : '';
$userSenha = isset($_REQUEST['senha']) ? $_REQUEST['senha'] : '';

$postdata = file_get_contents("php://input");

if (!empty($postdata)) {
    $request = isset($postdata) ? json_decode($postdata, true) : [];

    $userLogin = isset($request['login']) ? $request['login'] : '';
    $userSenha = isset($request['senha']) ? $request['senha'] : '';
}

$objUser = new UserAuth($userLogin, $userSenha, '');

$objUserTipo = new UserTipo();

$user = $objUser->getUser();

$usuLogado = isset($user['usu_logado']) ? $user['usu_logado'] : 'off';

$usuMsg = isset($user['usu_msg']) ? $user['usu_msg'] : '';

$ret = [
    'token'           => '',
    'msg'             => $usuMsg,
    'userName'        => '',
    'userTipo'        => '',
    'userTipoApelido' => '',
    'userCod'         => '',
    'success'         => false
];

if ($usuLogado == 'on') {
    $config = new Configuration();

    $signer = $config->getSigner(); // Default signer is HMAC SHA256

    $userTipoId = isset($user['usu_tipousu_id']) ? $user['usu_tipousu_id'] : '';

    $userTipo = $objUserTipo->info($userTipoId);

    $userTipoApelido = isset($userTipo['apelido']) ? $userTipo['apelido'] : '';

    $scope['uid']          = isset($user['usu_id']) ? $user['usu_id'] : '';
    $scope['uname']        = isset($user['usu_nome']) ? $user['usu_nome'] : '';
    $scope['utipoid']      = $userTipoId;
    $scope['utipoapelido'] = $userTipoApelido;
    $scope['ulogado']      = isset($user['usu_logado']) ? $user['usu_logado'] : '';
    $scope['utoken']       = isset($user['usu_token']) ? $user['usu_token'] : '';

    $objToken = $config->createBuilder()
                       ->setIssuer(JWT_ISSUER)// Configures the issuer (iss claim)
                       ->setId(JWT_ID, true)// Configures the id (jti claim), replicating as a header item
                       ->setIssuedAt(JWT_ISSUEAT)// Configures the time that the token was issue (iat claim)
                       //->setNotBefore(JWT_NOTBEFORE)// Configures the time that the token can be used (nbf claim)
                       ->setExpiration(JWT_EXPIRATION)// Configures the expiration time of the token (exp claim)
                       ->set('scope', $scope)// Configures a new claim, called "uid"
                       ->sign($signer, JWT_KEY)// creates a signature using "testing" as key
                       ->getToken(); // Retrieves the generated token

    $token = $objToken->__toString();

    $ret = [
        'token'           => $token,
        'msg'             => $usuMsg,
        'userId'          => $scope['uid'],
        'userName'        => $scope['uname'],
        'userTipo'        => $scope['utipoid'],
        'userTipoApelido' => $scope['utipoapelido'],
        'userToken'       => $scope['utoken'],
        'success'         => true
    ];
}

$url = json_encode($ret);

echo $url;