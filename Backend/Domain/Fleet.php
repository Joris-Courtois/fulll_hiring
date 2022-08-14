<?php

declare(strict_types=1);

namespace Backend\Domain;

class Fleet
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var array
     */
    protected $vehicles;

    public function __construct()
    {
        $this->vehicles = [];
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
     * @return array
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    /**
     * @param array $vehicle
     * @return Fleet
     */
    public function setVehicles(array $vehicle): Fleet
    {
        $this->vehicles = $vehicle;
        return $this;
    }

    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;
    }

    public function hasVehicle(Vehicle $vehicle): bool
    {
        return in_array($vehicle, $this->vehicles);
    }
}