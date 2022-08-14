<?php

declare(strict_types=1);

namespace Backend\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Fleet
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", nullable=false)
     *
     */
    protected $id;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Backend\Domain\Entity\User", mappedBy="fleet")
     */
    protected $user;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Backend\Domain\Entity\Vehicle", inversedBy="fleets", cascade={"persist"})
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
     * @return Fleet
     */
    public function setId(int $id): Fleet
    {
        $this->id = $id;
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
     * @param ArrayCollection $vehicle
     * @return Fleet
     */
    public function setVehicles(ArrayCollection $vehicle): Fleet
    {
        $this->vehicles = $vehicle;
        return $this;
    }

    /**
     * @param Vehicle $vehicle
     * @return void
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles->add($vehicle);
    }

    /**
     * @param Vehicle $vehicle
     * @return bool
     */
    public function hasVehicle(Vehicle $vehicle): bool
    {
        return $this->vehicles->contains($vehicle);
    }
}