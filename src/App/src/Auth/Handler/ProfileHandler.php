<?php declare(strict_types = 1);

namespace App\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class ProfileHandler implements \Psr\Http\Server\RequestHandlerInterface
{

	public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
	{
        return new JsonResponse(
            [
                'data' => \App\Auth\User\AuthenticatedUser::fromEntity(
                    $request->getAttribute(\App\Entity\User::class)
                )
            ]
        );
	}


}
