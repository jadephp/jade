<?php

use Cube\Cube;
use Cube\Core\AppDiscoveryProvider;
use Jade\Container;

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config.php';
$app = new Cube(new Container($config));

// 注册默认路由
$routeFactory = include __DIR__ . '/routes.php';
$routeFactory($app);

$app->register(new AppDiscoveryProvider(__DIR__ . '/../apps'));

return $app;