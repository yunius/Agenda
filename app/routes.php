<?php

$app->get('/', function () {
    require '../src/model.php';
    $entrees = getCollective();
    
    ob_start();             
    require '../views/index.php';
    $view = ob_get_clean(); 
    return $view;
});

