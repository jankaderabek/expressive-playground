<?php declare(strict_types=1);

namespace App\User\Authentication\Model\Authenticator;

use App\User\Authentication\Model\Authenticator\Exception\InvalidPassword;
use App\User\Authentication\Model\Authenticator\Exception\UndefinedEmail;
use App\User\Model\UserRepository;

class Authenticator
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PasswordService
     */
    private $passwordService;

    public function __construct(
        UserRepository $userRepository,
        PasswordService $passwordService
    ) {
        $this->userRepository = $userRepository;
        $this->passwordService = $passwordService;
    }

    /**
     * @throws InvalidPassword
     * @throws UndefinedEmail
     */
    public function authenticate(string $email, string $password): \App\Entity\User
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new UndefinedEmail();
        }

        if (!$this->passwordService->verifyPassword($password, $user->getPassword())) {
            throw new InvalidPassword();
        }

        return $user;
    }
}
