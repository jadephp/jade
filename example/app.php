<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Shein\App;
use Shein\Middleware\ErrorHandlerMiddleware;
use Shein\Console\CommandDiscovererProvider;
use Zend\Diactoros\Response;

$app = new App();

// middleware
$app->pipe(new ErrorHandlerMiddleware());
$app->pipe(function(ServerRequestInterface $request, RequestHandlerInterface $handler){
    $response = $handler->handle($request);
    return $response->withHeader('X-Shein-Version', '0.0.1');
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