
# 快速开始

SF 是个微内核框架，并不限制你的应用结构，你甚至可以在一个单文件里完成 `$app` 对象的构建;

```php
use Psr\Http\Message\ServerRequestInterface;
use Shein\App;
use Zend\Diactoros\Response;

$app = new App();

// 路由
$app->get('/ping', function(ServerRequestInterface $request){
    return new Response\TextResponse('pong');
});
$app->get('/greet/{name}', function(ServerRequestInterface $request, $name){
    return new Response\TextResponse(sprintf('Hi %s!', $name));
});

$app->serve();
```
