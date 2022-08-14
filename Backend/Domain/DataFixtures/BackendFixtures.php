<?php

namespace Backend\Domain\DataFixtures;

use Backend\Domain\Fleet;
use Backend\Domain\Location;
use Backend\Domain\User;
use Backend\Domain\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BackendFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $fleet = new Fleet();
        $user1 = new User();
        $user1->setUsername('Joris');
        $user1->setFleet($fleet);

        $user2 = new User();
        $user2->setUsername("Toto");


        $location = new Location();
        $location
            ->setLatitude(43.4850378)
            ->setLongitude(5.3758588)
        ;

        $vehicle1 = new Vehicle();
        $vehicle1->setPlateNumber("AA-123-BB");

        $vehicle2 = new Vehicle();
        $vehicle2->setPlateNumber("AA-456-BB");
        $vehicle2->setLocation($location);

        $fleet->addVehicle($vehicle2);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($fleet);
        $manager->persist($vehicle1);
        $manager->persist($vehicle2);
        $manager->persist($location);

        $manager->flush();
    }
}
