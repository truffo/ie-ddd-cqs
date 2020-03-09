<?php
declare(strict_types=1);

namespace Domain;

final class Location
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * Location constructor.
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return static
     */
    public static function fromString(string $locationAsString): self
    {
        list($latitude, $longitude) = sscanf($locationAsString, '%f,%f');

        return new self($latitude, $longitude);
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
