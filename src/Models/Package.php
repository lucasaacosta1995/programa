<?php

declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model;
use core\Models\CModel;

class Package extends CModel implements Model
{
    /**
     * Package weight
     *
     * @var float
     */
    protected float $weight;

    /**
     * Package tall
     *
     * @var float
     */
    protected float $tall;

    /**
     * Package long
     *
     * @var float
     */
    protected float $long;

    /**
     * Package wide
     *
     * @var float
     */
    protected float $wide;

    /**
     * Package tripId
     *
     * @var integer
     */
    protected int $tripId;

    /**
     * Package delivered
     *
     * @var boolean
     */
    protected bool $delivered;

    /**
     * Constructor Package
     *
     * @param float $weight
     * @param float $tall
     * @param float $long
     * @param float $wide
     * @param integer $tripId
     * @param boolean $delivered
     */
    function __construct(float $weight, float $tall, float $long, float $wide, int $tripId, bool $delivered)
    {
        $this->weight = $weight;
        $this->tall = $tall;
        $this->long = $long;
        $this->wide = $wide;
        $this->tripId = $tripId;
        $this->delivered = $delivered;
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
            'weight' => $this->getProperty($this, 'weight'),
            'tall' => $this->getProperty($this, 'tall'),
            'long' => $this->getProperty($this, 'long'),
            'wide' => $this->getProperty($this, 'wide'),
            'tripId' => $this->getProperty($this, 'tripId'),
            'delivered' => $this->getProperty($this, 'delivered')
        ];
    }
}
