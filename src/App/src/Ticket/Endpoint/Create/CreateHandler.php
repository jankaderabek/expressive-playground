<?php declare(strict_types=1);

namespace App\Ticket\Endpoint\Create;

use Psr\Http\Server\RequestHandlerInterface;

class CreateHandler implements RequestHandlerInterface
{
    /**
     * @var \App\Ticket\Model\TicketFacade
     */
    private $ticketFacade;

    public function __construct(\App\Ticket\Model\TicketFacade $ticketFacade)
    {
        $this->ticketFacade = $ticketFacade;
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        $createRequest = new CreateRequest($request->getParsedBody());

        $ticket = $this->ticketFacade->create(
            $createRequest->getTitle(),
            $request->getAttribute(\App\Entity\User::class)
        );

        return new \Zend\Diactoros\Response\JsonResponse(['id' => $ticket->getId()]);
    }
}
