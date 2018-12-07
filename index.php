<?php

include "vendor/autoload.php";

use Sketch\Route;

Route::get('/@id:[\d]+', function ($id) {

    echo $id;
});

Route::get('/', function () {

    echo "Ola mundo!";
});
