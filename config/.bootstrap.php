<?php

use Cube\Cube;
use Jade\Container;

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config.php';
$container = new Container($config);
$app = new Cube($container);

return $app;