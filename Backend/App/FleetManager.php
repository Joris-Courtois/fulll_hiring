<?php

declare(strict_types=1);

namespace Backend\App;


use Backend\Domain\Fleet;
use Backend\Domain\Vehicle;

class FleetManager
{
    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return void
     * @throws \Exception
     */
    public function register(Fleet $fleet, Vehicle $vehicle) : bool
    {
        if ($fleet->hasVehicle($vehicle)) {
            echo "The vehicle has already been registered in this fleet";
            return false;
        }

        $fleet->addVehicle($vehicle);

        return true;
    }
}