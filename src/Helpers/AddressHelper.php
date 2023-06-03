<?php

declare(strict_types=1);

namespace src\Helpers;

class AddressHelper
{
    /**
     * Calculate distance
     *
     * @param float $latitude1
     * @param float $longitude1
     * @param float $latitude2
     * @param float $longitude2
     * @return float
     */
    public static function getDistanceBetweenPoints(float $latitude1, float $longitude1, float $latitude2, float $longitude2): float
    {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        $distance = $distance * 1.609344;
        return (round($distance, 2));
    }
}
