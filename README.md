<p align="center">
  <a href="https://cakephp.org/" target="_blank" >
    <img alt="CakePHP" src="https://avatars2.githubusercontent.com/u/53564481?s=200" width="150" />
  </a>
</p>
<p align="center">
    <a href="LICENSE" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://travis-ci.org/jadephp/jade" target="_blank">
        <img alt="Build Status" src="https://img.shields.io/travis/jadephp/jade/master.svg?style=flat-square">
    </a>
    <a href="https://codecov.io/github/jadephp/jade" target="_blank">
        <img alt="Coverage Status" src="https://img.shields.io/codecov/c/github/jadephp/jade.svg?style=flat-square">
    </a>
    <a href="https://scrutinizer-ci.com/g/jadephp/jade/?branch=master" target="_blank">
        <img alt="Scrutinizer" src="https://img.shields.io/scrutinizer/g/jadephp/jade.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/jadephp/jade" target="_blank">
        <img alt="Latest Stable Version" src="https://img.shields.io/packagist/v/jadephp/jade.svg?style=flat-square&label=stable">
    </a>
</p>

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
 
