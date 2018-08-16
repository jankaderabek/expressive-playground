<?php declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use App;

class PingHandler implements RequestHandlerInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new JsonResponse(['ack' => (new \DateTime())->format('Y-m-d H:i:s')]);
    }
}
