<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

define('ROOT', dirname(__FILE__));

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/vendor/autoload.php';
$params = require __DIR__.'/config/main.php';

(new \app\Main($params))->run();
