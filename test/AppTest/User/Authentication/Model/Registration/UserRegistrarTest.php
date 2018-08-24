<?php declare(strict_types=1);

namespace AppTest\User\Authentication\Model\Registration;

use App\User\Authentication\Model\Authenticator\PasswordService;
use App\User\Authentication\Model\Registration\EmailAlreadyRegistered;
use App\User\Authentication\Model\Registration\UserRegistrar;
use App\User\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use Prophecy\Argument;

class UserRegistrarTest extends \PHPUnit\Framework\TestCase
{
    public function testRegisterWithExistingEmail()
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository
            ->findByEmail(Argument::type('string'))
            ->willReturn(new \App\Entity\User('email', 'password'))
        ;

        $userRegistrar = new UserRegistrar(
            $userRepository->reveal(),
            $this->prophesize(PasswordService::class)->reveal(),
            $this->prophesize(EntityManager::class)->reveal()
        );

        $this->expectException(EmailAlreadyRegistered::class);

        $userRegistrar->register('', '');
    }

    public function testRegister()
    {
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository
            ->findByEmail(Argument::type('string'))
            ->willReturn(null)
        ;

        $passwordService = $this->prophesize(PasswordService::class);
        $passwordService
            ->createPasswordHash(Argument::type('string'))
            ->willReturn('hash')
        ;

        $entityManager = $this->prophesize(EntityManager::class);
        $entityManager
            ->persist(Argument::type(\App\Entity\User::class))
            ->willReturn(null)
        ;
        $entityManager
            ->flush()
            ->willReturn(null)
        ;

        $userRegistrar = new UserRegistrar(
            $userRepository->reveal(),
            $passwordService->reveal(),
            $entityManager->reveal()
        );

        $user = $userRegistrar->register('email@email.com', 'secret');
        $this->assertInstanceOf(\App\Entity\User::class, $user);
        $this->assertEquals('email@email.com', $user->getEmail());
        $this->assertEquals('hash', $user->getPassword());
    }
}
