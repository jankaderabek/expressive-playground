<?php declare(strict_types=1);

namespace App\Ticket\Endpoint\AuthorList;

use App\Entity\User;
use App\Ticket\Entity\Ticket;
use App\Ticket\Model\TicketFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class ListHandler implements RequestHandlerInterface
{
    /**
     * @var TicketFacade
     */
    private $ticketFacade;

    public function __construct(TicketFacade $ticketFacade)
    {
        $this->ticketFacade = $ticketFacade;
    }

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): ResponseInterface
    {
        $tickets = $this->ticketFacade->getAuthorsTickets($request->getAttribute(User::class));

        $tickets = \Tightenco\Collect\Support\Collection::make($tickets)
            ->map(function (Ticket $ticket): array {
                return [
                    'id' => $ticket->getId(),
                    'title' => $ticket->getTitle(),
                    'created' => $ticket->getCreated(),
                ];
            })
        ;

        return new JsonResponse(['tickets' => $tickets->toArray()]);
    }
}
