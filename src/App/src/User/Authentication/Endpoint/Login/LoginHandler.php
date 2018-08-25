<?php declare(strict_types=1);

namespace App\User\Authentication\Endpoint\Login;

use Zend\Diactoros\Response\JsonResponse;

class LoginHandler implements \Psr\Http\Server\RequestHandlerInterface
{

    /**
     * @var \App\User\Authentication\Model\ApiTransfer\UserExchangeService
     */
    private $userExchangeService;

    /**
     * @var \App\User\Authentication\Model\Authenticator\Authenticator
     */
    private $authenticator;

    public function __construct(
        \App\User\Authentication\Model\Authenticator\Authenticator $authenticator,
        \App\User\Authentication\Model\ApiTransfer\UserExchangeService $userExchangeService
    ) {

        $this->authenticator = $authenticator;
        $this->userExchangeService = $userExchangeService;
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $loginRequest = new LoginRequest($request->getParsedBody());

        try {
            $user = $this->authenticator->authenticate($loginRequest->getEmail(), $loginRequest->getPassword());
        } catch (\App\User\Authentication\Model\Authenticator\Exception\InvalidCredentials $exception) {
            return new JsonResponse(['message' => 'Invalid credentials'], 400);
        }

        return new JsonResponse(['token' => $this->userExchangeService->createToken($user)]);
    }
}
