<?php declare(strict_types=1);

namespace RequestValidation\Model;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;

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
        $constraints = \Tightenco\Collect\Support\Collection::make($this->getConstraints());

        $violations = $constraints
            ->map(function ($fieldConstraints, $propertyName) use ($validator, $requestData) {
                $violations = $validator->validate($requestData[$propertyName], $fieldConstraints);
                $violations = \Tightenco\Collect\Support\Collection::make($violations);

                $violations = $violations
                    ->map(function (ConstraintViolationInterface $constraintViolation) use ($propertyName) {
                        return new RequestFieldViolation($propertyName, $constraintViolation);
                    })
                    ->all();

                $this->{$propertyName} = $requestData[$propertyName];

                return $violations;
            })
            ->flatten();

        if ($violations->isNotEmpty()) {
            throw new RequestDataConstraintViolation(...$violations->all());
        }
    }

    abstract protected function getConstraints(): array;
}
