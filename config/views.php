<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 18/05/2017
 * Time: 18:43
 */

return[
    'VIEW_PATH' => $_ENV['VIEW_PATH'] ?? 'public/views',
    'VIEW_CACHE'=> $_ENV['VIEW_CACHE'] ?? 'tmp/cache/views',
    'VIEW_HOMEPAGE' => $_ENV['VIEW_HOMEPAGE'] ?? 'index',
    'VIEW_HOME_TITLE' => $_ENV['APP_NAME'] ?? 'Painless'
];