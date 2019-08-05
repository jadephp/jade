<?php
use Cube\Cube;
use Zend\Diactoros\Response;

return function(Cube $app){
    $app->get('/ping', function(){
        return new Response\TextResponse('pong');
    });
};