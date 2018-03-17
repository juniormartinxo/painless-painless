<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 17/03/2018
 * Time: 14:24
 */
return [
    // Informações de conexão com o banco de dados
    'PATH_PROTECTED'   => explode('|', $_ENV['PATH_PROTECTED']),
    'PATH_PASSTHROUGH' => explode('|', $_ENV['PATH_PASSTHROUGH'])
];