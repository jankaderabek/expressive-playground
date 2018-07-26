<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App;

class PingHandler implements RequestHandlerInterface
{

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;


	public function __construct(\Doctrine\ORM\EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}


	public function handle(ServerRequestInterface $request) : ResponseInterface
    {
		$user = new App\Entity\User("new user");
		$this->entityManager->persist($user);
		$this->entityManager->flush();


        return new JsonResponse(['ack' => $this->entityManager->getRepository(\App\Entity\User::class)->findAll()]);
    }
}
