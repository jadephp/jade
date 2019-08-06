<?php

use Cube\Cube;
use Cube\Core\AppDiscoveryProvider;
use Jade\Container;
use Jade\Twig\TwigServiceProvider;

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config.php';
$container = new Container($config);
$app = new Cube($container);

// 注册默认路由
$routeFactory = include __DIR__ . '/routes.php';
$routeFactory($app);

$app->register(new AppDiscoveryProvider(__DIR__ . '/../apps'));
$app->register(new TwigServiceProvider());

return $app;