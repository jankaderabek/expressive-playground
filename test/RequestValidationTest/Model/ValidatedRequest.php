<?php declare(strict_types=1);

namespace RequestValidationTest\Model;

use RequestValidation\Model\AbstractValidRequest;
use Symfony\Component\Validator\Constraints;

final class ValidatedRequest extends AbstractValidRequest
{

    /**
     * @var string
     */
    protected $email;

    public function __construct(array $requestData)
    {
        parent::__construct($requestData);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function getConstraints(): array
    {
        return [
            'email' => [new Constraints\Type('string'), new Constraints\Email(), new Constraints\NotBlank()],
        ];
    }

}
