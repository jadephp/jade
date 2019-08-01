<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Jade\App;
use Jade\Middleware\ErrorHandlerMiddleware;
use Jade\Console\CommandDiscovererProvider;
use Zend\Diactoros\Response;

$app = new App();

// middleware
$app->pipe(new ErrorHandlerMiddleware());
$app->pipe(function(ServerRequestInterface $request, RequestHandlerInterface $handler){
    $response = $handler->handle($request);
    return $response->withHeader('X-Jade-Version', '0.0.1');
});

// 路由
$app->get('/ping', function(ServerRequestInterface $request){
    return new Response\TextResponse('pong');
});
$app->get('/greet/{name}', function(ServerRequestInterface $request, $name){
    return new Response\TextResponse(sprintf('Hi %s!', $name));
});

// 注册命令
$app->register(new CommandDiscovererProvider('', './Command'));
return $app;