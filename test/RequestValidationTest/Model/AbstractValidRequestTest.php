<?php declare(strict_types=1);

namespace RequestValidationTest\Model;

use PHPUnit\Framework\TestCase;
use RequestValidation\Model\RequestDataConstraintViolation;

class AbstractValidRequestTest extends TestCase
{

    public function testCreateRequestWithMissingRequiredField()
    {
        $this->expectException(RequestDataConstraintViolation::class);

        (new ValidatedRequest([]));
    }

    public function testCreateRequestWithValidData()
    {
        $validatedRequest = new ValidatedRequest(['requiredField' => 'some string']);

        $this->assertEquals('some string', $validatedRequest->getRequiredField());
    }

}
