<?php declare(strict_types=1);

namespace App\User\Authentication\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AuthenticatedMiddleware implements \Psr\Http\Server\MiddlewareInterface
{


    /**
     * @var \App\User\Authentication\Model\ApiTransfer\UserExchangeService
     */
    private $userExchangeService;

    public function __construct(
        \App\User\Authentication\Model\ApiTransfer\UserExchangeService $userExchangeService
    ) {

        $this->userExchangeService = $userExchangeService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authorizationHeaders = $request->getHeader('Authorization');
        $authorizationHeader = current($authorizationHeaders);

        if (!$authorizationHeader) {
            return $this->createUnauthorizedResponse("Missing header");
        }

        $authorizationToken = $this->getTokenFromAuthorizationHeader($authorizationHeader);

        try {
            $user = $this->userExchangeService->createFromToken($authorizationToken);
        } catch (\App\User\Authentication\Model\ApiTransfer\InvalidUserToken $e) {
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
