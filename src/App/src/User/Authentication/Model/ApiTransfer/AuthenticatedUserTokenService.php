<?php declare(strict_types=1);


namespace App\User\Authentication\Model\ApiTransfer;

class AuthenticatedUserTokenService
{

    private const KEY = 'secret';
    private const ALGORITHM = "HS256";

    public function createToken(AuthenticatedUser $user): string
    {
        return \Firebase\JWT\JWT::encode($user, self::KEY);
    }

    /**
     * @throws InvalidUserToken
     */
    public function createFromToken(string $token): AuthenticatedUser
    {
        try {
            $decodedIdentity = \Firebase\JWT\JWT::decode($token, self::KEY, [self::ALGORITHM]);
        } catch (\Throwable $e) {
            throw new InvalidUserToken();
        }

        return new AuthenticatedUser(
            $decodedIdentity->id,
            $decodedIdentity->email
        );
    }
}
