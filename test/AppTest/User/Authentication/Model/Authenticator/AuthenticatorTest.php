<?php

namespace AppTest\User\Authentication\Model\Authenticator;

use App\User\Authentication\Model\Authenticator\Authenticator;
use App\User\Authentication\Model\Authenticator\Exception\InvalidPassword;
use App\User\Authentication\Model\Authenticator\Exception\UndefinedEmail;
use App\User\Authentication\Model\Authenticator\PasswordService;
use App\User\Model\UserRepository;
use Prophecy\Argument;

class AuthenticatorTest extends \PHPUnit\Framework\TestCase
{
    public function testAuthenticateWithUnknownEmail(): void
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository
            ->findByEmail('')
            ->willReturn(null)
        ;

        $authenticator = new Authenticator(
            $userRepository->reveal(),
            $this->prophesize(PasswordService::class)->reveal()
        );
        $this->expectException(UndefinedEmail::class);

        $authenticator->authenticate('', '');
    }

    public function testAuthenticateWithInvalidPassword(): void
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository
            ->findByEmail('')
            ->willReturn(new \App\Entity\User('email', 'password'))
        ;

        $passwordService = $this->prophesize(PasswordService::class);
        $passwordService
            ->verifyPassword(Argument::type('string'), Argument::type('string'))
            ->willReturn(false)
        ;

        $authenticator = new Authenticator(
            $userRepository->reveal(),
            $passwordService->reveal()
        );
        $this->expectException(InvalidPassword::class);

        $authenticator->authenticate('', '');
    }

    public function testSuccessfullyAuthentication(): void
    {
        $user = new \App\Entity\User('email', 'password');

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository
            ->findByEmail('')
            ->willReturn($user)
        ;

        $passwordService = $this->prophesize(PasswordService::class);
        $passwordService
            ->verifyPassword(Argument::type('string'), Argument::type('string'))
            ->willReturn(true)
        ;

        $authenticator = new Authenticator(
            $userRepository->reveal(),
            $passwordService->reveal()
        );

        $authenticatedUser = $authenticator->authenticate('', '');
        $this->assertInstanceOf(\App\Entity\User::class, $authenticatedUser);
        $this->assertEquals($user, $authenticatedUser);
    }
}
