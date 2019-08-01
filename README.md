
# Jade Framework

Jade 是一个拥有简明语法，采用微内核设计的 PHP web框架。
 
## Installation

推荐使用 Composer 安装：

```bash
$ composer require jadephp/jade
```

## Quick Start

```php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

// 1. 创建应用
$app = new Jade\App();

// 2. 添加路由
$app->get('/ping', function(ServerRequestInterface $request){
    return new Response\TextResponse('pong');
});

// 3. 添加 middleware
$app->pipe(function(ServerRequestInterface $request, RequestHandlerInterface $handler){
   $response = $handler->handle($request);
   return $response->withHeader('X-Shein-Version', '0.0.1');
});

// 4. 提供服务
$app->serve();
```

以上代码即可实现一个简单的心跳应用；使用 `php -S 127.0.0.1:8000` 快速开启服务；使用浏览器打开 `http://127.0.0.1:8000` 即可访问

## Documentation

更多关于本框架的信息，请参与 [文档](./docs)

## Tests

你需要安装 `PHPUnit` 来执行单元测试；

```bash
$ phpunit
```

## License

The MIT license. See [MIT](https://opensource.org/licenses/MIT)
 