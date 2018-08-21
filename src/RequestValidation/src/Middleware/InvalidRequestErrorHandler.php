<?php declare(strict_types=1);

namespace RequestValidation\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RequestValidation\Model\RequestDataConstraintViolation;
use RequestValidation\Model\RequestFieldViolation;
use Zend\Diactoros\Response\JsonResponse;

class InvalidRequestErrorHandler implements \Psr\Http\Server\MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (RequestDataConstraintViolation $violation) {
            return $this->createErrorResponse($violation);
        }

        return $response;
    }

    private function createErrorResponse(RequestDataConstraintViolation $violation): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => array_map(function (RequestFieldViolation $requestFieldViolation) {
                    return [
                        'property' => $requestFieldViolation->getFieldName(),
                        'message' => $requestFieldViolation->getConstraintViolation()->getMessage()
                    ];
                }, $violation->getViolations()),
            ],
            400
        );
    }
}
