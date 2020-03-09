<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\Vehicle;
use Domain\VehiculeFleet;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var VehiculeFleet
     */
    private $myFleet;

    /**
     * @var Vehicle
     */
    private $aVehicle;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var VehiculeFleet
     */
    private $fleetOfAnotherUser;

    /**
     * @var string
     */
    private $anotherUserId;

    /**
     * @var \Domain\Location
     */
    private $aLocation;
    /**
     * @var bool
     */
    private $throwTryToRegisterThisVehicleIntoMyFleetException = false;
    /**
     * @var bool
     */
    private $throwTryToParkMyVehicleAtThisLocation = false;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->userId = 'user-id';
        $this->anotherUserId = 'another-user-id';
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        VehiculeFleet::clean();
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->myFleet = VehiculeFleet::ofUser($this->userId);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->aVehicle = new Vehicle('vehicule-1');
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->myFleet->registerVehicle($this->aVehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        Assert::assertTrue(VehiculeFleet::ofUser($this->userId)->contains($this->aVehicle));
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->myFleet->registerVehicle($this->aVehicle);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->myFleet->registerVehicle($this->aVehicle);
        }
        catch (LogicException $e) {
            $this->throwTryToRegisterThisVehicleIntoMyFleetException = true;
        }

    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        Assert::assertTrue($this->throwTryToRegisterThisVehicleIntoMyFleetException);
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->fleetOfAnotherUser = VehiculeFleet::ofUser($this->anotherUserId);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->fleetOfAnotherUser->registerVehicle($this->aVehicle);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->aLocation = \Domain\Location::fromString("43.5764082,4.4875113");
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->aVehicle->parkAtLocation($this->aLocation);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        Assert::assertEquals("43.5764082", $this->aVehicle->getLocation()->getLatitude());
        Assert::assertEquals("4.4875113", $this->aVehicle->getLocation()->getLongitude());
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->aVehicle->parkAtLocation($this->aLocation);
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try  {
            $this->aVehicle->parkAtLocation($this->aLocation);
        }
        catch (LogicException $e) {
            $this->throwTryToParkMyVehicleAtThisLocation = true;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        Assert::assertTrue($this->throwTryToParkMyVehicleAtThisLocation);
    }


}
