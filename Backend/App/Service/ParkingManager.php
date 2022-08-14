<?php

declare(strict_types=1);


namespace Backend\App\Service;

use Backend\Domain\Entity\Location;
use Backend\Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;

class ParkingManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Vehicle $vehicle
     * @param Location $location
     * @return bool
     */
    public function park(Vehicle $vehicle, Location $location): bool
    {
        if ($vehicle->getLocation() === $location) {
            echo "The vehicle is already parked at this location";
            return false;
        }

        $vehicle->setLocation($location);

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return true;
    }
}
