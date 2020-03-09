<?php
declare(strict_types=1);

namespace Domain;

/**
 * Class Vehicle.
 */
final class Vehicle
{
    /**
     * @var Location
     */
    private $location;

    /**
     * @var string
     */
    private $vehiculeId;

    /**
     * Vehicle constructor.
     */
    public function __construct(string $vehicleId)
    {
        $this->vehiculeId = $vehicleId;
    }

    public function parkAtLocation(Location $aLocation)
    {
        if (null !== $this->location) {
            throw new \LogicException('Vehicle already parked');
        }
        $this->location = $aLocation;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->vehiculeId;
    }
}
