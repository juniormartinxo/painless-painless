<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 16/07/2017
 * Time: 07:20
 */
return [
    // Informações de conexão com o banco de dados
    'PATH_ROOT' => dirname(path_root(),3),
    'PATH_WEB'  => dirname(path_web(),3),
    'PATH_ROUTES'  => dirname(path_root(),3) . DS . 'app' . DS . 'Routes',
    'PATH_CONTROLLERS'  => dirname(path_root(),3) . DS . 'app' . DS . 'Controllers',
    'PATH_MIDDLEWARES'  => dirname(path_root(),3) . DS . 'app' . DS . 'Middlewares'
];