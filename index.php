<?php
error_reporting(E_ALL); // error turn ON/OFF

require 'app/autoloader.php';
require 'app/Router.php';
require 'app/libs/Smarty.class.php';




$route->add('/', ['method' => 'GET', 'controller' => 'HomeController@index']);

// E X A M P L E
    // carId - validation int     0-9
    // name  - validation letter  A-Za-z

$route->add('/profile/{carId:int}/{name:letter}', [
    'method' => 'GET',              //  GET, POST, SEND(GET & POST)
    'controller' => 'profile@index' // 'profile' is controller name, and '@index' is profileController function.
]);


$route->start();