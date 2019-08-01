<p align="center" style="text-align:center"><a href="https://www.shein.com" target="_blank">SHEIN FRAMEWORK</a></p>

## 关于框架

 Shein Framework 以下简称“SF”, SF 是一个拥有简明语法与设计的微框架；灵感来自于 [Slim](https://github.com/slimphp/Slim)
 
## Quick Start

```php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

// 1. 创建应用
$app = new Shein\App();

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

## Contributors

框架由公共平台架构部开发二组维护；欢迎贡献代码；

## License

SF 框架面向公司内部开源，你可以免费使用创建你的应用。
 