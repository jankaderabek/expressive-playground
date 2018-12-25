<?php declare(strict_types=1);

namespace App\Ticket\Model;

use App\Entity\User;
use App\Ticket\Entity\Ticket;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

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

    /**
     * @var EntityRepository
     */
    private $ticketRepository;

    public function __construct(
        EntityManager $entityManager,
        TicketService $ticketService
    ) {
        $this->entityManager = $entityManager;
        $this->ticketService = $ticketService;
        $this->ticketRepository = $this->entityManager->getRepository(Ticket::class);
    }

    public function create(string $title, User $author): Ticket
    {
        $ticket = $this->ticketService->create($title, $author);

        $this->entityManager->persist($ticket);
        $this->entityManager->flush();

        return $ticket;
    }

    /**
     * @return User[]|iterable
     */
    public function getAuthorsTickets(User $user): iterable
    {
        return $this->ticketRepository->findBy([
            'author' => $user,
        ]);
    }

}
