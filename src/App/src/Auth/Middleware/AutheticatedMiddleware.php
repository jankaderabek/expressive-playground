<?php declare(strict_types=1);

namespace App\Auth\Middleware;

use Zend\Diactoros\Response\JsonResponse;

class AutheticatedMiddleware implements \Psr\Http\Server\MiddlewareInterface
{


    /**
     * @var \App\Auth\User\UserExchangeService
     */
    private $userExchangeService;

    public function __construct(
        \App\Auth\User\UserExchangeService $userExchangeService
    )
    {
        $this->userExchangeService = $userExchangeService;
    }

    public function process(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        $authorizationHeaders = $request->getHeader('Authorization');
        $authorizationHeader = current($authorizationHeaders);

        if (!$authorizationHeader) {
            return $this->createUnauthorizedResponse("Missing header");
        }

        $authorizationToken = $this->getTokenFromAuthorizationHeader($authorizationHeader);

        try {
            $user = $this->userExchangeService->createFromToken($authorizationToken);
        } catch (\App\Auth\User\InvalidUserToken $e) {
            return $this->createUnauthorizedResponse("Invalid token");
        }

        return $handler->handle($request->withAttribute(\App\Entity\User::class, $user));
    }


    private function getTokenFromAuthorizationHeader(string $authorizationHeader): ?string
    {
        if (!preg_match("/Bearer\s+(.*)$/i", $authorizationHeader, $matches)) {
            return null;
        }

        return $matches[1];
    }


    private function createUnauthorizedResponse(string $details): JsonResponse
    {
        return new JsonResponse(['message' => 'Unauthorized user' . $details], 401);
    }

}




