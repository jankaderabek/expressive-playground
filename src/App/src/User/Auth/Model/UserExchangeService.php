<?php declare(strict_types=1);


namespace App\User\Auth\Model;

class UserExchangeService
{

    /**
     * @var AuthenticatedUserTokenService
     */
    private $authenticatedUserTokenService;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $userRepository;

    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager,
        AuthenticatedUserTokenService $authenticatedUserTokenService
    ) {

        $this->authenticatedUserTokenService = $authenticatedUserTokenService;
        $this->userRepository = $entityManager->getRepository(\App\Entity\User::class);
    }

    public function createToken(\App\Entity\User $user): string
    {
        return $this->authenticatedUserTokenService->createToken(
            AuthenticatedUser::fromEntity($user)
        );
    }

    /**
     * @throws InvalidUserToken
     */
    public function createFromToken(string $token): \App\Entity\User
    {
        $authenticatedUser = $this->authenticatedUserTokenService->createFromToken($token);
        $user = $this->userRepository->findOneBy(['id' => $authenticatedUser->getId()]);

        if (!$user) {
            throw new InvalidUserToken();
        }

        return $user;
    }
}
