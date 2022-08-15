<?php

declare(strict_types=1);

namespace Tests\Context;

use App\Service\ParkingManager;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    private $parkingResult;

    /** @var ContainerInterface */
    private $container;

    public function __construct(ParkingManager $parkingManager, ContainerInterface $container)
    {
        $this->parkingManager = $parkingManager;
        $this->container = $container;
    }

    /** @BeforeScenario  */
    public function resetDatabase()
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropDatabase();
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->createSchema($metadata);
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->featureContext = $environment->getContext('Tests\Context\FeatureContext');
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        $this->parkingResult = $this->parkingManager->park($vehicle, $location);

        if (!$this->parkingResult) {
            throw new \Exception('Impossible to park my vehicle at this location');
        }
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

        $this->parkingResult = $this->parkingManager->park($vehicle, $location);

        if (!$this->parkingResult) {
            throw new \Exception('Impossible to park my vehicle at this location');
        }
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        $vehicle = $this->featureContext->getVehicle();
        $location = $this->featureContext->getLocation();

        $this->parkingResult = $this->parkingManager->park($vehicle, $location);
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if (false !== $this->parkingResult) {
            throw new \Exception(
                "I am not informed that this vehicle can't be parked twice at the same location"
            );
        }
    }
}
