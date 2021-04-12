<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes/api.php';

use Dotenv\Dotenv;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$dotenv = new DotEnv(__DIR__);
$dotenv->load();
