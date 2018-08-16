<?php declare(strict_types=1);

namespace RequestValidation\Model;

use Symfony\Component\Validator\Validation;
use function var_dump;

abstract class AbstractValidRequest
{

    /**
     * @throws RequestDataConstraintViolation
     */
    public function __construct(array $requestData)
    {
        $this->mapData($requestData);
    }

    /**
     * @throws RequestDataConstraintViolation
     */
    private function mapData(array $requestData): void
    {
        $validator = Validation::createValidator();

        foreach ($this->getConstraints() as $propertyName => $constraints) {
            $violations = $validator->validate($requestData[$propertyName], $constraints);

            if (count($violations)) {
                throw new RequestDataConstraintViolation($violations);
            }

            $this->{$propertyName} = $requestData[$propertyName];
        }
    }

    abstract protected function getConstraints(): array;
}
