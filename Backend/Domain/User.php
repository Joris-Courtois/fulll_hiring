<?php

declare(strict_types=1);

namespace Backend\Domain;

class User
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Fleet
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
     * @return Fleet
     */
    public function getFleet(): Fleet
    {
        return $this->fleet;
    }

    /**
     * @param Fleet $fleet
     * @return User
     */
    public function setFleet(Fleet $fleet): User
    {
        $this->fleet = $fleet;
        return $this;
    }
}