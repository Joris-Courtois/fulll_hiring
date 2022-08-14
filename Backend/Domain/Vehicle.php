<?php

declare(strict_types=1);

namespace Backend\Domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Vehicle
{
    /**
     * @var int
     * @ORM\Id()
     */
    protected $id;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Vehicle
     */
    public function setId(int $id): Vehicle
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Location
     */
    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     * @return Vehicle
     */
    public function setLocation(Location $location): Vehicle
    {
        $this->location = $location;
        return $this;
    }
}