<?php declare(strict_types=1);

namespace RequestValidationTest\Model;

use PHPUnit\Framework\TestCase;
use RequestValidation\Model\RequestDataConstraintViolation;

class AbstractValidRequestTest extends TestCase
{

    public function testCreateRequestWithMissingRequiredField()
    {
        try {
            (new ValidatedRequest(['email' => 1]));
        } catch (RequestDataConstraintViolation $e) {
        }

        $this->assertInstanceOf(RequestDataConstraintViolation::class, $e);
        $this->assertCount(2, $e->getViolations());
    }

    public function testCreateRequestWithValidData()
    {
        $validatedRequest = new ValidatedRequest(['email' => 'email@gmail.com']);

        $this->assertEquals('email@gmail.com', $validatedRequest->getEmail());
    }

}
