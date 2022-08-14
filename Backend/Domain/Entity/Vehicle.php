<?php

declare(strict_types=1);

namespace Backend\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Vehicle
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length="9", nullable=false, unique=true)
     */
    protected $plateNumber;

    /**
     * @var Location
     * @ORM\ManyToOne(targetEntity="Backend\Domain\Entity\Location", inversedBy="vehicles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $location;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Backend\Domain\Entity\Fleet", mappedBy="vehicles", cascade={"persist"})
     */
    protected $fleets;

    public function __construct()
    {
        $this->fleets = new ArrayCollection();
    }

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
     * @return string
     */
    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    /**
     * @param string $plateNumber
     * @return Vehicle
     */
    public function setPlateNumber(string $plateNumber): Vehicle
    {
        $this->plateNumber = $plateNumber;
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
    public function setLocation(?Location $location): Vehicle
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFleets(): ArrayCollection
    {
        return $this->fleets;
    }

    /**
     * @param ArrayCollection $fleets
     * @return Vehicle
     */
    public function setFleets(ArrayCollection $fleets): Vehicle
    {
        $this->fleets = $fleets;
        return $this;
    }
}