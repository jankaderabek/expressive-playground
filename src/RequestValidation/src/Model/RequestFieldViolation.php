<?php declare(strict_types=1);

namespace RequestValidation\Model;

use Symfony\Component\Validator\ConstraintViolationInterface;

final class RequestFieldViolation
{

    /**
     * @var string
     */
    private $fieldName;
    /**
     * @var ConstraintViolationInterface
     */
    private $constraintViolation;

    public function __construct(string $fieldName, ConstraintViolationInterface $constraintViolation)
    {
        $this->fieldName = $fieldName;
        $this->constraintViolation = $constraintViolation;
    }

    public function getFieldName(): string
    {
        return $this->fieldName;
    }

    public function getConstraintViolation(): ConstraintViolationInterface
    {
        return $this->constraintViolation;
    }
}
