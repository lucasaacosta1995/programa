<?php

declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model;
use core\Models\CModel;

class Trip extends CModel implements Model
{
    /**
     * Origin id address model
     *
     * @var integer
     */
    protected int $originId;

    /**
     * Destination id address model
     *
     * @var integer
     */
    protected int $destinationId;

    /**
     * Type priority
     *
     * @var integer
     */
    protected int $typePriority;

    /**
     * Ended status
     *
     * @var integer
     */
    protected bool $ended;

    /**
     * Travel route grouped 
     *
     * @var integer
     */
    protected int $travelRouteId;


    /**
     * Constructor Trip
     *
     * @param integer $originId
     * @param integer $destinationId
     * @param integer $typePriority
     * @param boolean $ended
     * @param integer $travelRouteId
     */
    function __construct(int $originId, int $destinationId, int $typePriority, bool $ended, int $travelRouteId)
    {
        $this->originId = $originId;
        $this->destinationId = $destinationId;
        $this->typePriority = $typePriority;
        $this->ended = $ended;
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
            'originId' => $this->getProperty($this, 'originId'),
            'destinationId' => $this->getProperty($this, 'destinationId'),
            'typePriority' => $this->getProperty($this, 'typePriority'),
            'ended' => $this->getProperty($this, 'ended'),
            'travelRouteId' => $this->getProperty($this, 'travelRouteId'),
        ];
    }
}
