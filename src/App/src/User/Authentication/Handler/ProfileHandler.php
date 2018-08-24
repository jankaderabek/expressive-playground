<?php declare(strict_types=1);

namespace App\User\Authentication\Handler;

use Zend\Diactoros\Response\JsonResponse;

class ProfileHandler implements \Psr\Http\Server\RequestHandlerInterface
{

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return new JsonResponse(
            [
                'data' => \App\User\Authentication\Model\ApiTransfer\AuthenticatedUser::fromEntity(
                    $request->getAttribute(\App\Entity\User::class)
                )
            ]
        );
    }
}
