<?php
declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model;
use core\Models\CModel;

class TravelRoute extends CModel implements Model
{

    /**
     * Date init
     *
     * @var string
     */
    protected string $initDate;

    /**
     * Date end limit
     *
     * @var string
     */
    protected string $endDate;

    /**
     * Travel route children
     *
     * @var integer
     */
    protected int $travelRouteChildrenId;

    /**
     * Constructor TravelRoute
     *
     * @param string $initDate
     * @param string $endDate
     * @param integer $travelRouteChildrenId
     */
    function __construct(string $initDate, string $endDate, int $travelRouteChildrenId = 0)
    {
        $this->initDate = $initDate;
        $this->endDate = $endDate;
        $this->travelRouteChildrenId = $travelRouteChildrenId;
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
            'initDate' => $this->getProperty($this, 'initDate'),
            'endDate' => $this->getProperty($this, 'endDate'),
            'travelRouteChildrenId' => $this->getProperty($this, 'travelRouteChildrenId')
        ];
    }
}