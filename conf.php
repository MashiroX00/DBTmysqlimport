<?php
session_start();
require "vendor/autoload.php";
require "Modules/CssPackage.php";
require "Modules/Log.php";
require "Modules/Control.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$adminusername = $_ENV['ADMINUSER'];
$adminpassword = $_ENV['ADMINPASS'];
$Mysqlhost = $_ENV['HOST'];

$Protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$hostip = $_SERVER['HTTP_HOST'];
$primaryurl = $Protocol . "://" . $hostip;
$path = $_ENV['APP'];
$url = $primaryurl . $path;

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__FILE__));
}


try {
    $conn = new PDO("mysql:$Mysqlhost",$adminusername,$adminpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(Exception $e) {
    echo "ERROR: " . $e->getMessage();
}

$LOAD = new CssPackage(ROOT_DIR,$url);
$Control = new Control($conn);
$LOG = new LOG();