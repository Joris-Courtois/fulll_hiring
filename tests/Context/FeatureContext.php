<?php

declare(strict_types=1);

namespace Tests\Context;

use Domain\Entity\User;
use Behat\Behat\Context\Context;
use Domain\Entity\Vehicle;
use Domain\Entity\Location;
use Domain\Entity\Fleet;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * @var Vehicle
     */
    private $vehicle;

    /**
     * @var Fleet
     */
    private $myFleet;

    /**
     * @var Fleet
     */
    private $anotherFleet;

    /**
     * @var Location
     */
    private $location;

    /** @var EntityManagerInterface */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->myFleet = new Fleet();

        $user = new User();
        $user->setUsername("Me");
        $user->setFleet($this->myFleet);

        $this->entityManager->persist($user);
        $this->entityManager->persist($this->myFleet);

        $this->entityManager->flush();
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->vehicle = new Vehicle();
        $this->vehicle->setPlateNumber('AA-789-BB');

        $this->entityManager->persist($this->vehicle);
        $this->entityManager->flush();
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->anotherFleet = new Fleet();

        $user = new User();
        $user->setUsername('You');
        $user->setFleet($this->anotherFleet);

        $this->entityManager->persist($this->anotherFleet);
        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->location = new Location();
        $this->location
            ->setLatitude(43.4850378)
            ->setLongitude(5.3758588)
        ;

        $this->entityManager->persist($this->location);
        $this->entityManager->flush();
    }

    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @return Fleet
     */
    public function getMyFleet(): Fleet
    {
        return $this->myFleet;
    }

    /**
     * @return Fleet
     */
    public function getAnotherFleet(): Fleet
    {
        return $this->anotherFleet;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }
}
