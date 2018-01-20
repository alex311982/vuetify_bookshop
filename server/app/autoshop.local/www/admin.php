<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("BASE_CONTROLLER", "BookController");

include("config/config.php");
include("libraries/autoloader.php");



$app = new App($config); 
$app->start();