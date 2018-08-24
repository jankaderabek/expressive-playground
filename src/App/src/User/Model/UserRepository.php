<?php declare(strict_types=1);

namespace App\User\Model;

use Doctrine\ORM\EntityManager;

class UserRepository
{

    /**
     * @var \Doctrine\ORM\Repository\RepositoryFactory
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(\App\Entity\User::class);
    }

    public function findByEmail(string $email): ?\App\Entity\User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
