<?php declare(strict_types=1);

namespace RequestValidationTest\Middleware;

use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RequestValidation\Middleware\CallableMiddlewareRequestFactory;
use RequestValidationTest\Model\ValidatedRequest;

class CallableMiddlewareRequestFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $callableRequestFactory = CallableMiddlewareRequestFactory::create(ValidatedRequest::class);

        $serverRequest = $this->prophesize(ServerRequestInterface::class);
        $serverRequest
            ->getParsedBody()
            ->willReturn(['email' => 'email@gmail.com'])
        ;
        $serverRequest
            ->withAttribute(ValidatedRequest::class, Argument::type(ValidatedRequest::class))
            ->willReturn($this->prophesize(ServerRequestInterface::class)->reveal())
        ;

        $handler = $this->prophesize(RequestHandlerInterface::class);
        $handler
            ->handle(Argument::type(ServerRequestInterface::class))
            ->willReturn($this->prophesize(ResponseInterface::class))
        ;

        $response = $callableRequestFactory($serverRequest->reveal(), $handler->reveal());
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
