<?php declare(strict_types=1);

namespace App\Ticket\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @var User
     */
    private $author;

    public function __construct(string $title, User $author)
    {
        $this->title = $title;
        $this->author = $author;
        $this->created = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
