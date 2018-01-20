<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("BASE_CONTROLLER", "IndexController");

include("config/config.php");
include("libraries/autoloader.php");



$app = new App($config);
$app->start();
