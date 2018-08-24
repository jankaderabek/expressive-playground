<?php /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
declare(strict_types=1);

namespace App\User\Authentication\Handler;

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

        $user = $this->authenticator->authenticate($loginRequest->getEmail(), $loginRequest->getPassword());

        return new JsonResponse(['token' => $this->userExchangeService->createToken($user)]);
    }
}
