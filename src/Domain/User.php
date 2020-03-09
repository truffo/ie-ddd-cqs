<?php
declare(strict_types=1);

namespace Domain;

final class User
{
    /**
     * @var VehiculeFleet
     */
    private $myFleet;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->myFleet = new VehiculeFleet();
    }

    /**
     * @return VehiculeFleet
     */
    public function getFleet()
    {
        return $this->myFleet;
    }
}
