<?php

declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model as InterfaceModel;
use core\Models\CModel;

class ModelTruck extends CModel implements InterfaceModel
{

    /**
     * name specific model truck
     *
     * @var string
     */
    protected string $name;

    /**
     * model volume specific
     *
     * @var float
     */
    protected float $volume;

    /**
     * maximum Weight supported
     *
     * @var float
     */
    protected float $maximumSupport;

    /**
     * @param string $name
     * @param float $volume
     * @param float $maximumSupport
     */
    function __construct(string $name, float $volume, float $maximumSupport)
    {
        $this->name = $name;
        $this->volume = $volume;
        $this->maximumSupport = $maximumSupport;
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
            'volume' => $this->getProperty($this, 'volume'),
            'maximumSupport' => $this->getProperty($this, 'maximumSupport'),
        ];
    }
}
