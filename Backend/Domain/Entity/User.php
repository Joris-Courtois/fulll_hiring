<?php

declare(strict_types=1);

namespace Backend\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length="20", nullable=false)
     */
    protected $username;

    /**
     * @var Fleet
     * @ORM\OneToOne(targetEntity="Backend\Domain\Entity\Fleet", inversedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $fleet;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return ?Fleet
     */
    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    /**
     * @param ?Fleet $fleet
     * @return User
     */
    public function setFleet(?Fleet $fleet): User
    {
        $this->fleet = $fleet;

        return $this;
    }
}
