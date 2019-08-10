<?php

/*
 * This file is part of the jade/jade package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jade\Controller;

use Jade\ContainerAwareInterface;
use Jade\ContainerAwareTrait;
use Zend\Diactoros\Response;

class Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * 渲染模板
     * @param string $view
     * @param array $parameters
     * @return string
     */
    protected function renderView($view, array $parameters = [])
    {
        return $this->container->get('twig')->render($view, $parameters);
    }

    /**
     * 渲染模板
     *
     * @param string $view
     * @param array $parameters
     * @return Response\HtmlResponse
     */
    protected function render($view, array $parameters = [])
    {
        $content = $this->renderView($view, $parameters);
        return new Response\HtmlResponse($content);
    }

    /**
     * @param string $id
     * @return mixed
     */
    protected function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @final
     */
    protected function json($data, int $status = 200, array $headers = [], array $context = [])
    {
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge([
                'json_encode_options' => Response\JsonResponse::DEFAULT_JSON_FLAGS,
            ], $context));
        }
        return new Response\JsonResponse($data, $status, $headers);
    }
}