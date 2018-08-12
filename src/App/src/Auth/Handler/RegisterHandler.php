<?php declare(strict_types = 1);

namespace App\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class RegisterHandler implements \Psr\Http\Server\RequestHandlerInterface
{

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManager $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}


	public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
	{
		$userRepository = $this->entityManager->getRepository(\App\Entity\User::class);
		$data = $request->getParsedBody();


		if ($userRepository->findOneBy(['email' => $data['email']])) {
			return new JsonResponse(['message' => 'Email is already used'], 400);
		}

		$user = new \App\Entity\User(
			$data['email'],
			password_hash($data['password'], PASSWORD_ARGON2I)
		);

		$this->entityManager->persist($user);
		$this->entityManager->flush();

		return new JsonResponse(['user' => $user, 'token' => \Firebase\JWT\JWT::encode($user, 'key')]);
	}

}
