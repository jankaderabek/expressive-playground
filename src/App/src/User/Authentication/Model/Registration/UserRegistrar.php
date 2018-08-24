<?php declare(strict_types = 1);

namespace App\User\Authentication\Model\Registration;

use App\Entity\User;
use App\User\Authentication\Model\Authenticator\PasswordService;
use App\User\Model\UserRepository;
use Doctrine\ORM\EntityManager;

class UserRegistrar
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordService
     */
    private $passwordService;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        PasswordService $passwordService,
        EntityManager $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
        $this->entityManager = $entityManager;
    }

    public function register(string $email, string $password): User
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new EmailAlreadyRegistered();
        }

        $user = new User(
            $email,
            $this->passwordService->createPasswordHash($password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
