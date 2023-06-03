<?php
declare(strict_types=1);

namespace src\Models;

use core\Interfaces\Model;
use core\Models\CModel;

class TypeTrip extends CModel implements Model
{

    /**
     * Type trip normal
     *
     * @var integer
     */
    protected static int $typeNormal = 1;

    /**
     * Type trip priority
     *
     * @var integer
     */
    protected static int $typePriority = 2;

    /**
     * Type trip refund
     *
     * @var integer
     */
    protected static int $typeRefund = 3;

    /**
     * Name type trip
     *
     * @var string
     */
    protected string $name;

    /**
     * Slug type trip
     *
     * @var integer
     */
    protected int $slug;

    /**
     * Constructor TypeTrip
     *
     * @param string $name
     * @param integer $slug
     */
    function __construct(string $name, int $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }


    /**
     * Return variable static normal
     *
     * @return integer
     */
    public static function getTypeNormal(): int
    {
        return self::$typeNormal;
    }

    /**
     * Return variable static priority
     *
     * @return integer
     */
    public static function getTypePriority(): int
    {
        return self::$typePriority;
    }

    /**
     * Return variable static refund
     *
     * @return integer
     */
    public static function getTypeRefund(): int
    {
        return self::$typeRefund;
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
            'slug' => $this->getProperty($this, 'slug')
        ];
    }
}