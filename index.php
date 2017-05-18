<?php
/**
 * Created by PhpStorm.
 * User: Junior
 * Date: 13/05/2017
 * Time: 14:32
 */

include "bootstrap.php";

$template = $twig->load('index.html');

echo $template->render();