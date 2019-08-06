<?php

use Zend\ConfigAggregator\ConfigAggregator;

$aggregator = new ConfigAggregator([
        
], 'config-cache.php');
return $aggregator->getMergedConfig();