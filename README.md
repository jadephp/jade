# Jade Framework


[![Build Status](https://img.shields.io/travis/jadephp/jade/master.svg?style=flat-square)](https://travis-ci.org/jadephp/jade)
[![Coverage Status](https://img.shields.io/codecov/c/github/jadephp/jade.svg?style=flat-square)](https://codecov.io/github/jadephp/jade)
[![Latest Stable Version](https://img.shields.io/packagist/v/jadephp/jade.svg?style=flat-square&label=stable)](https://packagist.org/packages/jadephp/jade)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/jadephp/jade.svg?style=flat-square)](https://scrutinizer-ci.com/g/jadephp/jade/?branch=master)
[![Packagist](https://img.shields.io/packagist/l/jadephp/jade?style=flat-square)](https://packagist.org/packages/jadephp/jade)

Jade is a flexible PHP micro framework to develop web applications and APIs
 
## Installation

The recommended way to install Jade is through Composer:

```bash
$ composer require jadephp/jade
```

## Quick Start

```php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;

// 1. Create App
$app = new Jade\App();

// 2. Add routes
$app->get('/ping', function(ServerRequestInterface $request){
    return new Response\TextResponse('pong');
});

// 3. Add middlewares
$app->pipe(function(ServerRequestInterface $request, RequestHandlerInterface $handler){
   $response = $handler->handle($request);
   return $response->withHeader('X-Jade-Version', '0.0.1');
});

// 4. Listen and serve.
$app->serve();
```

The above code can create a simple heartbeat application.

Test this with the built-in PHP server:

```bash
php -S 127.0.0.1:8000
```
Use the browser open `http://127.0.0.1:8000/ping`

## Documentation

Read the [documentation](./docs/index.md) for more information 

## Tests

To run the test suite, you need PHPUnit:

```bash
$ phpunit
```

## License

Jade is licensed under The MIT license. See [MIT](https://opensource.org/licenses/MIT)
 
