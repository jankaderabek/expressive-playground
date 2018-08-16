<?php declare(strict_types=1);

namespace RequestValidationTest\RequestValidation\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RequestValidation\Model\RequestDataConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Zend\Diactoros\Response\JsonResponse;
use RequestValidation\Middleware\InvalidRequestErrorHandler;

class InvalidRequestErrorHandlerTest extends TestCase
{

    public function testProcessWithConstraintViolationThrown()
    {
        $invalidRequestErrorHandler = new InvalidRequestErrorHandler();

        $violationsList = $this->prophesize(ConstraintViolationList::class);
        $violationsList->__toString()->willReturn("Hello world");

        $response = $invalidRequestErrorHandler->process(
            $this->prophesize(ServerRequestInterface::class)->reveal(),
            new class($violationsList->reveal()) implements RequestHandlerInterface {

                /**
                 * @var ConstraintViolationList
                 */
                private $violationList;

                public function __construct(ConstraintViolationList $prophetviolationList)
                {
                    $this->violationList = $prophetviolationList;
                }

                public function handle(ServerRequestInterface $request): ResponseInterface
                {
                    throw new RequestDataConstraintViolation($this->violationList);
                }
            }
        );

        $this->assertInstanceOf(JsonResponse::class, $response);

    }
}
