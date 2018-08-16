<?php declare(strict_types=1);

namespace App\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class LoginHandler implements \Psr\Http\Server\RequestHandlerInterface
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \App\Auth\User\UserExchangeService
     */
    private $userExchangeService;


    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        \App\Auth\User\UserExchangeService $userExchangeService
    ) {

        $this->entityManager = $entityManager;
        $this->userExchangeService = $userExchangeService;
    }


    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $userRepository = $this->entityManager->getRepository(\App\Entity\User::class);
        $loginRequest = new LoginRequest($request->getParsedBody());

        /** @var \App\Entity\User $user */
        $user = $userRepository->findOneBy(['email' => $loginRequest->getEmail()]);

        if (!$user) {
            return new JsonResponse(['message' => 'Unknown user'], 400);
        }

        if (!password_verify($loginRequest->getPassword(), $user->getPassword())) {
            return new JsonResponse(['message' => 'Invalid credentials'], 400);
        }

        return new JsonResponse(
            [
                'token' => $this->userExchangeService->createToken($user),
            ]
        );
    }
}
