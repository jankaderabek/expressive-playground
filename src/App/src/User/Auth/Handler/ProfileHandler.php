<?php declare(strict_types=1);

namespace App\User\Auth\Handler;

use Zend\Diactoros\Response\JsonResponse;

class ProfileHandler implements \Psr\Http\Server\RequestHandlerInterface
{

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return new JsonResponse(
            [
                'data' => \App\User\Auth\Model\AuthenticatedUser::fromEntity(
                    $request->getAttribute(\App\Entity\User::class)
                )
            ]
        );
    }
}
