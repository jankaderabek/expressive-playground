<?php declare(strict_types=1);

namespace RequestValidationTest\Model;

use RequestValidation\Model\AbstractValidRequest;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ValidatedRequest extends AbstractValidRequest
{

    /**
     * @var string
     */
    protected $requiredField;

    public function __construct(array $requestData)
    {
        parent::__construct($requestData);
    }

    public function getRequiredField(): string
    {
        return $this->requiredField;
    }

    protected function getConstraints(): array
    {
        return [
            'requiredField' => new NotBlank(),
        ];
    }

}
