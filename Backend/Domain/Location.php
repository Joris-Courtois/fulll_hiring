<?php

declare(strict_types=1);

namespace Backend\Domain;

class Location
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var array
     */
    protected $vehicles;

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
     * @return array
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    /**
     * @param array $vehicles
     * @return Location
     */
    public function setVehicles(array $vehicles): Location
    {
        $this->vehicles = $vehicles;
        return $this;
    }
}