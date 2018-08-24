<?php declare(strict_types=1);

namespace App\User\Authentication\Model\ApiTransfer;

class AuthenticatedUser implements \JsonSerializable
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    public function __construct(
        int $id,
        string $email
    ) {

        $this->id = $id;
        $this->email = $email;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }

    public static function fromEntity(\App\Entity\User $user): self
    {
        return new self(
            $user->getId(),
            $user->getEmail()
        );
    }
}
