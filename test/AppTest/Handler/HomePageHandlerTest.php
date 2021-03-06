<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\HomePageHandler;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandlerTest extends TestCase
{

    public function testReturnsJsonResponse()
    {
        $homePageHandler = new HomePageHandler();

		$serverRequest = new \Zend\Diactoros\ServerRequest();
		$serverRequest->withParsedBody([
			'parameter' => 'value'
		]);

        $response = $homePageHandler->handle(
			$serverRequest
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertArrayHasKey('welcome', json_decode($response->getBody()->getContents(), TRUE));
    }
}
