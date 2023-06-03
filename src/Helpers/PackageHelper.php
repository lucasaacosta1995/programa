<?php

declare(strict_types=1);

namespace src\Helpers;

use Exception;

class PackageHelper
{
    /**
     * get weight or volume m3 by packages
     *
     * @param array $packages
     * @param string $field
     * @return float
     */
    public static function getTotalsByFieldPackages(array $packages, string $field = 'weight'): float
    {
        $total = 0.00;
        foreach ($packages as $package) {
            if($field === 'weight') {
                $total += round($package->{$field});
            } elseif($field === 'volume') {
                $total += round($package->tall * $package->long * $package->wide);
            }            
        }
        return $total;
    }
}
