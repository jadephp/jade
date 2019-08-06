<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$cacheFile = __DIR__ . '/../var/cache/cached-config.php';

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/app.php'),
], $cacheFile);

return $aggregator->getMergedConfig();