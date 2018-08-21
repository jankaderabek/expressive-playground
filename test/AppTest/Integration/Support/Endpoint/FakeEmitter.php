<?php declare(strict_types=1);

namespace AppTest\Integration\Support\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\EmitterInterface;

class FakeEmitter implements EmitterInterface
{
    /**
     * @var ResponseInterface|null
     */
    private $response;

    public function emit(ResponseInterface $response): bool
    {
        $this->response = $response;

        return true;
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }
}
