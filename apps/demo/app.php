<?php

use Zend\Diactoros\Response;

$app = new \Cube\Core\App('demo', true);

$app->setRoutesFactory(function(\Cube\Cube $cube){
    $cube->get('/demo', function(){
        return new Response\TextResponse('this is from the demo app');
    });
});

return $app;