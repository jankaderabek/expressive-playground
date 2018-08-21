<?php declare(strict_types=1);

namespace RequestValidationTest\RequestValidation\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RequestValidation\Model\RequestDataConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Zend\Diactoros\Response\JsonResponse;
use RequestValidation\Middleware\InvalidRequestErrorHandler;

class InvalidRequestErrorHandlerTest extends TestCase
{

    public function testProcessWithConstraintViolationThrown()
    {
        $invalidRequestErrorHandler = new InvalidRequestErrorHandler();
        $violation = $this->prophesize(ConstraintViolationInterface::class);

        $response = $invalidRequestErrorHandler->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            new class($violation->reveal()) implements RequestHandlerInterface {

                /**
                 * @var ConstraintViolationInterface
                 */
                private $violation;

                public function __construct(ConstraintViolationInterface $violation)
                {
                    $this->violation = $violation;
                }

                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    throw new RequestDataConstraintViolation(
                        new \RequestValidation\Model\RequestFieldViolation(
                            "test field",
                            $this->violation
                        )
                    );
                }
            }
        );

        $this->assertInstanceOf(JsonResponse::class, $response);

    }
}
