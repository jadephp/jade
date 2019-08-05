<?php

use Cube\Cube;
use Cube\Core\AppDiscoveryProvider;

include __DIR__ . '/../vendor/autoload.php';

$app = new Cube();

// 注册默认路由
$routeFactory = include __DIR__ . '/routes.php';
$routeFactory($app);

$app->register(new AppDiscoveryProvider(__DIR__ . '/../apps'));

return $app;