<?php declare(strict_types = 1);

namespace src\Models;

use core\Interfaces\Model as InterfaceModel;
use core\Models\CModel;

class Truck extends CModel implements InterfaceModel 
{

    /**
     * identity model ModelTruck
     *
     * @var integer
     */
    protected int $modelId;

    /**
     * license plate number for the truck
     *
     * @var string
     */
    protected string $patent;

    /**
     * Constructor Truck
     *
     * @param integer $modelId
     * @param string $patent
     */
    function __construct(int $modelId, string $patent)
    {
        $this->modelId = $modelId;
        $this->patent = $patent;
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
            'modelId' => $this->getProperty($this, 'modelId'),
            'patent' => $this->getProperty($this, 'patent')
        ];
    }

}
