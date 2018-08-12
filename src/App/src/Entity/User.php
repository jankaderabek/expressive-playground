<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="foo")
 */
class User implements \JsonSerializable
{

	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\Column(name="name", type="string", unique=true)
	 * @var string
	 */
	private $email;

	/**
	 * @ORM\Column(name="password", type="string")
	 * @var string
	 */
	private $password;


	public function __construct(string $email, string $password)
	{

		$this->email = $email;
		$this->password = $password;
	}


	public function getEmail(): string
	{
		return $this->email;
	}


	public function getPassword(): string
	{
		return $this->password;
	}


	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'email' => $this->email,
			'password' => $this->password,
		];
	}
}
