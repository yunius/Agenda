<?php

$app->get('/', function () use($app) {
    $collectives = $app['dao.collective']->findAll();    
    ob_start();             
    require '../views/index.php';
    $view = ob_get_clean(); 
    return $view;
});

