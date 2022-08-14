<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Backend\Domain\Vehicle;
use Backend\Domain\Location;
use Backend\Domain\Fleet;

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

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->myFleet = new Fleet();
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->vehicle = new Vehicle();
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->anotherFleet = new Fleet;
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->location = new Location();
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
