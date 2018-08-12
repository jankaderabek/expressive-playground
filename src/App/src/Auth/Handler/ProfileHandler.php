<?php declare(strict_types = 1);

namespace App\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class ProfileHandler implements \Psr\Http\Server\RequestHandlerInterface
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
		$authorizationHeader = $request->getHeader('Authorization')[0];

		if (preg_match("/Bearer\s+(.*)$/i", $authorizationHeader, $matches)) {
			$token = $matches[1];

			return new JsonResponse(['data' => ((array) \Firebase\JWT\JWT::decode($token, 'key', ["HS256"]))]);
		}


		return new JsonResponse(['email' => 'email']);
	}


}
