<?php

declare(strict_types=1);

namespace Tests\Context;

use Backend\App\Service\FleetManager;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegisterVehicleFeatureContext implements Context
{
    /**
     * @var FleetManager
     */
    private $fleetManager;

    /**
     * @var bool
     */
    private $registerResult;

    /**
     * @var FeatureContext
     */
    private $featureContext;

    /** @var ContainerInterface */
    private $container;

    public function __construct(FleetManager $fleetManager, ContainerInterface $container)
    {
        $this->fleetManager = $fleetManager;
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
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        $this->registerResult = $this->fleetManager->register($myFleet, $vehicle);

        if (!$this->registerResult) {
            throw new \Exception('Error when registering the vehicle in this fleet');
        }
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        $this->registerResult = $this->fleetManager->register($myFleet, $vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        if (!$myFleet->hasVehicle($vehicle) || !$this->registerResult) {
            throw new \Exception("The vehicle is not in my fleet");
        }
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        $this->registerResult = $this->fleetManager->register($myFleet, $vehicle);
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if (false !== $this->registerResult) {
            throw new \Exception("I am not informed that this vehicle is already in my fleet");
        }
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $anotherFleet = $this->featureContext->getAnotherFleet();

        $this->registerResult = $this->fleetManager->register($anotherFleet, $vehicle);

        if (!$this->registerResult) {
            throw new \Exception('Impossible to register this vehicle to another fleet');
        }
    }
}
