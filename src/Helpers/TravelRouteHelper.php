<?php

declare(strict_types=1);

namespace src\Helpers;

require_once dirname(dirname(dirname(__FILE__))) . '\constants.php';

use src\Models\TypeTrip;

class TravelRouteHelper
{
    /**
     * Calculate cost by travel route
     *
     * @param integer $travelRouteId
     * @param integer $travelRouteChildrenId
     * @param array $trips
     * @param array $packages
     * @param array $travelRoutes
     * @param array $address
     * @param array $typesTrips
     * @return float
     */
    public static function calculateCost(int $travelRouteId, int $travelRouteChildrenId, array $trips, array $packages, array $travelRoutes, array $address, array $typesTrips): float
    {
        $cost = 0.00;

    
        if (isset($trips[$travelRouteId])) {
            
            foreach ($trips[$travelRouteId] as $tripId => $trip) {
                if(!isset($typesTrips[$trip->typePriority]))
                    continue;

                
                switch ($typesTrips[$trip->typePriority]->slug) {
                    case TypeTrip::getTypeNormal():
                        $cost += self::calculateCostNormal($tripId, $trip->originId, $trip->destinationId, $packages, $address);
                        break;
                    case TypeTrip::getTypePriority($tripId):
                        $cost += self::calculateCostPriority($tripId, $trip->originId, $trip->destinationId, $packages, $address);
                        break;
                    case TypeTrip::getTypeRefund():
                        $cost += self::calculateCostRefund();
                        break;
                    default:
                        break;
                }
            }
        }

        if (
            $travelRouteChildrenId > 0 && isset($travelRoutes[$travelRouteChildrenId])
        ) {
            $cost += self::calculateCost(
                $travelRoutes[$travelRouteChildrenId],
                $travelRoutes[$travelRouteChildrenId]->travelRouteChildrenId,
                $trips,
                $packages,
                $travelRoutes,
                $address,
                $typesTrips
            );
        }

        return $cost;
    }

    /**
     * Calculate cost by type trip normal
     *
     * @param integer $tripId
     * @param integer $originId
     * @param integer $destinationId
     * @param array $packages
     * @param array $address
     * @return float
     */
    public static function calculateCostNormal(int $tripId, int $originId, int $destinationId, array $packages, array $address): float
    {
        //trip-> originId -> address -> latitude and longitude
        $fee = COST_TRIP_NORMAL;
        $cost = 0.00;
        $kilometerTraveled = 0;
        if ((isset($address[$originId]->latitude) && isset($address[$originId]->longitude)) &&
            (isset($address[$destinationId]->latitude) && isset($address[$destinationId]->longitude))
        ) {
            $kilometerTraveled = AddressHelper::getDistanceBetweenPoints(
                $address[$originId]->latitude,
                $address[$originId]->longitude,
                $address[$destinationId]->latitude,
                $address[$destinationId]->longitude
            );

            $totalWeightPackages = isset($packages[$tripId]) && is_array($packages[$tripId]) && count($packages[$tripId]) > 0
                ? PackageHelper::getTotalsByFieldPackages($packages[$tripId]) : 0.00;

            $cost = $fee * $totalWeightPackages * $kilometerTraveled;
        }

        

        return $cost;
    }

    /**
     * Calculate cost by type trip priority KG and Volume m3
     *
     * @param integer $tripId
     * @param integer $originId
     * @param integer $destinationId
     * @param array $packages
     * @param array $address
     * @return float
     */
    public static function calculateCostPriority(int $tripId, int $originId, int $destinationId, array $packages, array $address): float
    {
        $costOne = self::calculateCostPriorityKg($tripId, $originId, $destinationId, $packages, $address);
        $costTwo = self::calculateCostPriorityVolume($tripId, $originId, $destinationId, $packages, $address);

        return $costOne > $costTwo ? $costTwo : $costOne;
    }

    /**
     * Calculate cost by type trip priority KG
     *
     * @param integer $tripId
     * @param integer $originId
     * @param integer $destinationId
     * @param array $packages
     * @param array $address
     * @return float
     */
    public static function calculateCostPriorityKg(int $tripId, int $originId, int $destinationId, array $packages, array $address): float
    {
        //trip-> originId -> address -> latitude and longitude
        $fee = COST_TRIP_PRIORITY_KG;
        $cost = 0.00;
        $kilometerTraveled = 0;
        if ((isset($address[$originId]->latitude) && isset($address[$originId]->longitude)) &&
            (isset($address[$destinationId]->latitude) && isset($address[$destinationId]->longitude))
        ) {
            $kilometerTraveled = AddressHelper::getDistanceBetweenPoints(
                $address[$originId]->latitude,
                $address[$originId]->longitude,
                $address[$destinationId]->latitude,
                $address[$destinationId]->longitude
            );

            $totalWeightPackages = isset($packages[$tripId]) && is_array($packages[$tripId]) && count($packages[$tripId]) > 0
                ? PackageHelper::getTotalsByFieldPackages($packages[$tripId]) : 0.00;

            $cost = $fee * $totalWeightPackages * $kilometerTraveled;
        }

        return $cost;
    }

    /**
     * Calculate cost by type trip priority Volume m3
     *
     * @param integer $tripId
     * @param integer $originId
     * @param integer $destinationId
     * @param array $packages
     * @param array $address
     * @return float
     */
    public static function calculateCostPriorityVolume(int $tripId, int $originId, int $destinationId, array $packages, array $address): float
    {
        //trip-> originId -> address -> latitude and longitude
        $fee = COST_TRIP_PRIORITY_VOLUME;
        $cost = 0.00;
        $kilometerTraveled = 0;
        if ((isset($address[$originId]->latitude) && isset($address[$originId]->longitude)) &&
            (isset($address[$destinationId]->latitude) && isset($address[$destinationId]->longitude))
        ) {
            $kilometerTraveled = AddressHelper::getDistanceBetweenPoints(
                $address[$originId]->latitude,
                $address[$originId]->longitude,
                $address[$destinationId]->latitude,
                $address[$destinationId]->longitude
            );

            $totalWeightPackages = isset($packages[$tripId]) && is_array($packages[$tripId]) && count($packages[$tripId]) > 0
                ? PackageHelper::getTotalsByFieldPackages($packages[$tripId], 'volume') : 0.00;

            $cost = $fee * $totalWeightPackages * $kilometerTraveled;
        }

        return $cost;
    }

    /**
     * Calculate cost by type trip refund
     *
     * @return float
     */
    public static function calculateCostRefund(): float
    {
        return round(COST_TRIP_REFUND, 2);
    }
}
