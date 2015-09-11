<?php

ini_set('display_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

define('APP_ABSPATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));

$composer_autoload = APP_ABSPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (!is_file($composer_autoload)) {
    die("Configuração do composer não encontrada! \nPor favor instale o composer!");
}

// Including global autoloader
require_once $composer_autoload;
