<?php declare(strict_types=1);

namespace App\Ticket\Model;

class TicketService
{
    public function create(string $title, \App\Entity\User $author)
    {
        return new \App\Ticket\Entity\Ticket($title, $author);
    }
}
