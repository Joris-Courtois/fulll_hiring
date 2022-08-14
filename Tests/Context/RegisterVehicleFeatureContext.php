<?php

declare(strict_types=1);

namespace Tests\Context;

use Backend\App\Service\FleetManager;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

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

    public function __construct(FleetManager $fleetManager)
    {

        $this->fleetManager = $fleetManager;
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

        $this->fleetManager->register($myFleet, $vehicle);
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        $this->fleetManager->register($myFleet, $vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $myFleet = $this->featureContext->getMyFleet();

        if (!$myFleet->hasVehicle($vehicle)) {
            throw new \Exception ("The vehicle is not in my fleet");
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
        if(false !== $this->registerResult)
        {
            throw new \Exception();
        }
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $vehicle = $this->featureContext->getVehicle();
        $anotherFleet = $this->featureContext->getAnotherFleet();

        $this->fleetManager->register($anotherFleet, $vehicle);
    }

}