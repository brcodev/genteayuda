<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../public_html');
$dotenv->safeLoad();


require 'db.php';
require 'parameters.php';


use Model\ActiveRecord;
ActiveRecord::setDB($db);
