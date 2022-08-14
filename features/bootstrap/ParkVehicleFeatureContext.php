<?php

declare(strict_types=1);

use Backend\App\ParkingManager;
use Backend\Domain\Location;
use Backend\Domain\Vehicle;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;

class ParkVehicleFeatureContext implements Context
{
    /**
     * @var ParkingManager
     */
    private $parkingManager;

    /**
     * @var FeatureContext
     */
    private $featureContext;

    /**
     * @var bool
     */
    private $parkResult;

    public function __construct()
    {
        $this->parkingManager = new ParkingManager();
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->featureContext = $environment->getContext('FeatureContext');
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        $this->parkingManager->park($vehicle, $location);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        if ($vehicle->getLocation() !== $location) {
            throw new \Exception('The vehicle location is different than the expected one');
        }
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        $this->parkingManager->park($vehicle, $location);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        $this->parkResult = $this->parkingManager->park($vehicle, $location);
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if (false !== $this->parkResult) {
            throw new \Exception("The vehicle can't be parked twice at the same location");
        }
    }
}