<?php declare(strict_types=1);

namespace RequestValidation\Model;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestDataConstraintViolation extends \Exception
{

    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(RequestFieldViolation ...$violations)
    {
        parent::__construct((string) $violations);
        $this->violations = $violations;
    }

    /**
     * @return RequestFieldViolation[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
