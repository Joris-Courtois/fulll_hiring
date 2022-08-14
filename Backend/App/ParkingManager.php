<?php

declare(strict_types=1);


namespace Backend\App;

use Backend\Domain\Location;
use Backend\Domain\Vehicle;

class ParkingManager
{
    public function park(Vehicle $vehicle, Location $location)
    {
        if($vehicle->getLocation() === $location) {
            echo "The vehicle is already parked at this location";
            return false;
        }

        $vehicle->setLocation($location);

        return true;
    }
}