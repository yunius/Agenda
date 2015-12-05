<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['locale'] = 'fr';

require __DIR__.'/app/config/dev.php';
require __DIR__.'/app/app.php';
require __DIR__.'/app/routes.php';

$app->run();