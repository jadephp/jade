<?php

use Symfony\Component\Console\Input\ArgvInput;
use Shein\Console\Application;

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/Command/HelloCommand.php';

set_time_limit(0);

$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('ENV_OVERWRITTEN') ?: 'prod');
$debug = !$input->hasParameterOption(array('--no-debug', '')) && $env !== 'prod';
$debug && \Symfony\Component\Debug\Debug::enable();

$app = include __DIR__ . '/app.php';
$console = new Application($app);
$console->run();