<?php

declare(strict_types=1);

namespace Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 */
class Location
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    protected $latitude;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=false)
     */
    protected $longitude;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Domain\Entity\Vehicle", mappedBy="location")
     */
    protected $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
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
     * @return Location
     */
    public function setId(int $id): Location
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Location
     */
    public function setLatitude(float $latitude): Location
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Location
     */
    public function setLongitude(float $longitude): Location
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getVehicles(): ArrayCollection
    {
        return $this->vehicles;
    }

    /**
     * @param ArrayCollection $vehicles
     * @return Location
     */
    public function setVehicles(ArrayCollection $vehicles): Location
    {
        $this->vehicles = $vehicles;
        return $this;
    }
}
