<?php declare(strict_types=1);

namespace App\User\Authentication\Endpoint\Registration;

use App\User\Authentication\Model\Registration\EmailAlreadyRegistered;
use App\User\Authentication\Model\Registration\UserRegistrar;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $registrationRequest = new RegistrationRequest($request->getParsedBody());

        try {
            $this->userRegistrar->register($registrationRequest->getEmail(), $registrationRequest->getPassword());
        } catch (EmailAlreadyRegistered $e) {
            return new JsonResponse(['message' => 'Email already registered'], 400);
        }

        return new JsonResponse(['status' => 'success']);
    }
}
