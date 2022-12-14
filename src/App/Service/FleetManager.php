<?php

declare(strict_types=1);

namespace App\Service;

use Domain\Entity\Fleet;
use Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;

class FleetManager
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return bool
     * @throws \Exception
     */
    public function register(Fleet $fleet, Vehicle $vehicle) : bool
    {
        if ($fleet->hasVehicle($vehicle)) {
            return false;
        }

        $fleet->addVehicle($vehicle);
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();

        return true;
    }
}
