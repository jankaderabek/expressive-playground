<?php declare(strict_types=1);

namespace App\Ticket\Model;

use App\Entity\User;
use App\Ticket\Entity\Ticket;
use Doctrine\ORM\EntityManager;

class TicketFacade
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TicketService
     */
    private $ticketService;

    public function __construct(
        EntityManager $entityManager,
        TicketService $ticketService
    ) {
        $this->entityManager = $entityManager;
        $this->ticketService = $ticketService;
    }

    public function create(string $title, User $author): Ticket
    {
        $ticket = $this->ticketService->create($title, $author);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }
}
