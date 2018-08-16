<?php declare(strict_types=1);

namespace RequestValidation\Model;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestDataConstraintViolation extends \Exception
{

    /**
     * @var ConstraintViolationListInterface
     */
    private $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        parent::__construct((string) $violations);
        $this->violations = $violations;
    }

}
