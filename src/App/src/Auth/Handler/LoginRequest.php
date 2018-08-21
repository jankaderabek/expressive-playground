<?php declare(strict_types=1);


namespace App\Auth\Handler;

use RequestValidation\Model\AbstractValidRequest;
use Symfony\Component\Validator\Constraints as Assert;

final class LoginRequest extends AbstractValidRequest
{

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    public function __construct(array $requestData)
    {
        parent::__construct($requestData);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    protected function getConstraints(): array
    {
        return [
            'email' => [new Assert\Type('string'), new Assert\Email(), new Assert\NotBlank()],
            'password' => new Assert\Type('string'),

        ];
    }
}
