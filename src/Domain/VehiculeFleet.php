<?php
declare(strict_types=1);

namespace Domain;


final class VehiculeFleet
{
    /**
     * @var array|VehiculeFleet[]
     */
    private static $fleets = [];

    /**
     * @var string
     */
    private $userId;

    /**
     * @var array|Vehicle[]
     */
    private $vehicles = [];

    /**
     * VehiculeFleet constructor.
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return static
     */
    public static function ofUser(string $userId): self
    {
        if (!array_key_exists($userId, self::$fleets)) {
            self::$fleets[$userId] = new VehiculeFleet($userId);
        }

        return self::$fleets[$userId];
    }

    public function registerVehicle(Vehicle $aVehicle)
    {
        if ($this->contains($aVehicle)) {
            throw new \LogicException('Vehicle already register in this fleet');
        }
        $this->vehicles[$aVehicle->getId()] = $aVehicle;
    }

    /**
     * @return bool
     */
    public function contains(Vehicle $aVehicle)
    {
        return array_key_exists($aVehicle->getId(), $this->vehicles);
    }

    public static function clean()
    {
        self::$fleets = [];
    }
}
