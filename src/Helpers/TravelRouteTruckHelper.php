<?php

declare(strict_types=1);

namespace src\Helpers;

use Exception;

class TravelRouteTruckHelper
{

    /**
     * validation truck support weight packages
     *
     * @param float $maximumsSupport
     * @param float $totalWeightPackages
     * @return boolean
     */
    public static function validateMaximumSupport(float $maximumsSupport, float $totalWeightPackages): bool
    {
        if($totalWeightPackages > $maximumsSupport)
            throw new Exception("Error, total Weight packages is totalWeightPackages and is > the trunck support: $maximumsSupport");

        return true;
    }
}
