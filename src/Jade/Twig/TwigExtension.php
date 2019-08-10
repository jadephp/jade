<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Twig;

use Jade\Routing\Router;
use Psr\Http\Message\UriInterface;

class TwigExtension extends \Twig\Extension\AbstractExtension
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var string|UriInterface
     */
    private $uri;

    public function __construct($router, $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function getName()
    {
        return 'slim';
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('path_for', array($this, 'pathFor')),
            new \Twig\TwigFunction('full_url_for', array($this, 'fullUrlFor')),
            new \Twig\TwigFunction('base_url', array($this, 'baseUrl')),
            new \Twig\TwigFunction('is_current_path', array($this, 'isCurrentPath')),
            new \Twig\TwigFunction('current_path', array($this, 'currentPath')),
        ];
    }

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    /**
     * Similar to pathFor but returns a fully qualified URL
     *
     * @param string $name The name of the route
     * @param array $data Route placeholders
     * @param array $queryParams
     * @param string $appName
     * @return string fully qualified URL
     */
    public function fullUrlFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        $path = $this->pathFor($name, $data, $queryParams, $appName);
        /** @var Uri $uri */
        if (is_string($this->uri)) {
            $uri = Uri::createFromString($this->uri);
        } else {
            $uri = $this->uri;
        }
        $scheme = $uri->getScheme();
        $authority = $uri->getAuthority();
        $host = ($scheme ? $scheme . ':' : '')
            . ($authority ? '//' . $authority : '');
        return $host . $path;
    }

    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    public function isCurrentPath($name, $data = [])
    {
        return $this->router->pathFor($name, $data) === $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');
    }

    /**
     * Returns current path on given URI.
     *
     * @param bool $withQueryString
     * @return string
     */
    public function currentPath($withQueryString = false)
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        $path = $this->uri->getBasePath() . '/' . ltrim($this->uri->getPath(), '/');
        if ($withQueryString && '' !== $query = $this->uri->getQuery()) {
            $path .= '?' . $query;
        }
        return $path;
    }

    /**
     * Set the base url
     *
     * @param string|Slim\Http\Uri $baseUrl
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->uri = $baseUrl;
    }
}