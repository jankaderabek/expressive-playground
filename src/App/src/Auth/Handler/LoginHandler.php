<?php declare(strict_types = 1);

namespace App\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class LoginHandler implements \Psr\Http\Server\RequestHandlerInterface
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

		/** @var \App\Entity\User $user */
		$user = $userRepository->findOneBy(['email' => $data['email']]);


		if ( ! $user) {
			return new JsonResponse(['error' => 'unkknown user']);
		}

		if ( ! password_verify($data['password'], $user->getPassword())) {
			return new JsonResponse(['error' => 'invalid credentials']);
		}

		return new JsonResponse(['user' => $user, 'token' => \Firebase\JWT\JWT::encode($user, 'key')]);
	}


}
