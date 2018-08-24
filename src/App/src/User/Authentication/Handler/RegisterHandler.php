<?php declare(strict_types=1);

namespace App\User\Authentication\Handler;

use App\User\Authentication\Model\Registration\UserRegistrar;
use Zend\Diactoros\Response\JsonResponse;

class RegisterHandler implements \Psr\Http\Server\RequestHandlerInterface
{
    /**
     * @var UserRegistrar
     */
    private $userRegistrar;

    public function __construct(
        UserRegistrar $userRegistrar
    ) {

        $this->userRegistrar = $userRegistrar;
    }


    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $data = $request->getParsedBody();

        $this->userRegistrar->register($data['email'], $data['password']);

        return new JsonResponse(['status' => 'success']);
    }
}
