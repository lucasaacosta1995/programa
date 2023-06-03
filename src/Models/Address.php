<?php

declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model as InterfacesModel;
use core\Models\CModel;

class Address extends CModel implements InterfacesModel
{

    /**
     * Name address
     *
     * @var string
     */
    protected string $name;

    /**
     * Coordinate latitude
     *
     * @var float
     */
    protected float $latitude;

    /**
     * Coordinate longitude
     *
     * @var float
     */
    protected float $longitude;

    /**
     * Constructor Address
     *
     * @param string $name
     * @param float $latitude
     * @param float $longitude
     */
    function __construct(string $name, float $latitude, float $longitude)
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get properties by model. 
     * return specific fields
     *
     * @return object
     */
    public function getProperties(): object
    {
        return (object)[
            'name' => $this->getProperty($this, 'name'),
            'latitude' => $this->getProperty($this, 'latitude'),
            'longitude' => $this->getProperty($this, 'longitude')
        ];
    }

}