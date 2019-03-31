<?php declare(strict_types=1);

namespace RequestValidation\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CallableMiddlewareRequestFactory
{
    public static function create(string $requestDataClassName): callable
    {
        return function (
            ServerRequestInterface $request,
            RequestHandlerInterface $handler
        ) use ($requestDataClassName) : ResponseInterface {
            $requestObject = new $requestDataClassName($request->getParsedBody());

            return $handler->handle($request->withAttribute($requestDataClassName, $requestObject));
        };
    }
}
