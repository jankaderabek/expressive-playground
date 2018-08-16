<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router;
use Zend\Expressive\Template;
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class HomePageHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new JsonResponse([
            'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
            'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
        ]);
    }
}
