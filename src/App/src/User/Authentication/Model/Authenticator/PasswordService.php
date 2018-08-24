<?php declare(strict_types=1);

namespace App\User\Authentication\Model\Authenticator;

class PasswordService
{

    public function createPasswordHash(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public function verifyPassword(string $inputPassword, string $passwordHash): bool
    {
        return password_verify($inputPassword, $passwordHash);
    }
}
