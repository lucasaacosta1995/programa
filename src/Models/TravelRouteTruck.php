<?php
declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model;
use core\Models\CModel;

class TravelRouteTruck extends CModel implements Model
{

    /**
     * Truck id relation
     *
     * @var integer
     */
    protected int $truckId;

    /**
     * Travel route id relation
     *
     * @var integer
     */
    protected int $travelRouteId;

    /**
     * Constructor TravelRouteTruck
     *
     * @param integer $truckId
     * @param integer $travelRouteId
     */
    function __construct(int $truckId, int $travelRouteId)
    {
        $this->truckId = $truckId;
        $this->travelRouteId = $travelRouteId;
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
            'truckId' => $this->getProperty($this, 'truckId'),
            'travelRouteId' => $this->getProperty($this, 'travelRouteId')
        ];
    }
}