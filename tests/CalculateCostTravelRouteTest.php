<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Helpers\PackageHelper;
use src\Helpers\TravelRouteHelper;
use src\Models\ModelTruck;
use src\Models\Truck;
use src\Models\Address;
use src\Models\TravelRoute;
use src\Models\TypeTrip;
use src\Models\Trip;
use src\Models\Package;
use src\Models\TravelRouteTruck;

use src\Helpers\TravelRouteTruckHelper;

final class CalculateCostTravelRouteTest extends TestCase
{

    protected array $storage;
    protected int $storageAutoIncrement = 0;

    protected array $packages;
    protected array $trips;
    protected array $address;
    protected array $travelRoutes;
    protected array $typeTrips;

    /**
     * Undocumented function
     *
     * @param object $data
     * @return int
     */
    private function setStorage(object $object): int
    {
        $id = $this->storageAutoIncrement++;
        $this->storage[$id] = $object->getProperties();

        return $id;
    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return object
     */
    private function getObjectStorage(int $id): object
    {
        if(!isset($this->storage[$id]))
            throw new Error("object not exists");

        return $this->storage[$id];
    }

    private function setAndGetObjectInStorage(object $object): array
    {
        $id = $this->setStorage($object);
        return array($id, $this->getObjectStorage($id));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function generateAddressData(string $name, float $latitude, float $longitude): array
    {
        $address = new Address($name, $latitude, $longitude);
        return $this->setAndGetObjectInStorage($address);
    }

    /**
     * Undocumented function
     *
     * @param integer $travelRouteChildrenId
     * @return array
     */
    private function generateTravelRouteData(int $travelRouteChildrenId = 0): array
    {
        $initDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime(date('Y-m-d'). " + 3 day"));
        $travelRoute = new TravelRoute($initDate, $endDate, $travelRouteChildrenId);
        return $this->setAndGetObjectInStorage($travelRoute);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function generateModelTruckData(string $name, float $volume, float $maximumSupport): array
    {
        $modelTruck = new ModelTruck($name, $volume, $maximumSupport);
        return $this->setAndGetObjectInStorage($modelTruck);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function generateTypeTripData(string $name, int $slug): array
    {
        $typeTrip = new typeTrip($name, $slug);
        return $this->setAndGetObjectInStorage($typeTrip);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function generateTripData(int $originId, int $destinationId, int $typePriority, bool $ended, int $travelRouteId): array
    {
        $trip = new Trip($originId, $destinationId, $typePriority, $ended, $travelRouteId);
        return $this->setAndGetObjectInStorage($trip);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function generatePackageData(float $weight, float $tall, float $long, float $wide, int $tripId, bool $delivered): array
    {
        $package = new Package($weight, $tall, $long, $wide, $tripId, $delivered);
        return $this->setAndGetObjectInStorage($package);
    }

    // public function testCostPriorityTravelRoute()
    
    /**
     * Undocumented function
     *
     * @param string $typeTripName
     * @param integer $typeTripSlug
     * @return float
     */
    public function calculateCostTraveRouteByTypeTrip(string $typeTripName, int $typeTripSlug): float
    {
        list($typeTripId, $typeTripData) = $this->generateTypeTripData($typeTripName, $typeTripSlug);
        $this->typeTrips[$typeTripId] = $typeTripData;
        
        list($addressInitId, $addressInitData) = $this->generateAddressData("Wilde", -34.7066528, -58.3428114);
        $this->address[$addressInitId] = $addressInitData;

        list($addressEndId, $addressEndData) = $this->generateAddressData("Hospital Italiano de Buenos Aires", -34.592662, -58.431068);
        $this->address[$addressEndId] = $addressEndData;

        list($travelRouteId, $travelRouteData) = $this->generateTravelRouteData();
        $this->travelRoutes[$travelRouteId] = $travelRouteData;
        
        list($modelTruckId, $modelTruckData) = $this->generateModelTruckData("Model 1", 60.0, 2000);

        list($tripId, $tripData) = $this->generateTripData($addressInitId, $addressEndId, $typeTripId, false, $travelRouteId);
        $this->trips[$travelRouteId][$tripId] = $tripData;

        $packagesJson = json_decode(file_get_contents('mockedata/packages.json'));
        foreach($packagesJson as $pkg) {
            list($pkgTmpId, $pkgTmpData) = $this->generatePackageData($pkg->weight, $pkg->tall, $pkg->long, $pkg->wide, $pkg->tripId, $pkg->delivered);
            $this->packages[$tripId][$pkgTmpId] = $pkgTmpData;
        }

        $totalWeightPackages = 0.00;
        if(isset($this->trips[$travelRouteId])) {
            foreach($this->trips[$travelRouteId] as $tripIdTmp => $tripTmp) {
                if(isset($this->packages[$tripIdTmp])) {
                    $totalWeightPackages += PackageHelper::getTotalsByFieldPackages($this->packages[$tripIdTmp]);
                }
            }
        }

        return TravelRouteHelper::calculateCost($travelRouteId, $travelRouteData->travelRouteChildrenId, $this->trips, $this->packages, $this->travelRoutes, $this->address, $this->typeTrips);
    }
    

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCostNormalTravelRoute()
    {
        $cost = $this->calculateCostTraveRouteByTypeTrip("Normal", TypeTrip::getTypeNormal());
        $this->assertSame(21042.0, $cost);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCostPriorityTravelRoute()
    {
        $cost = $this->calculateCostTraveRouteByTypeTrip("Prioritario", TypeTrip::getTypePriority());
        $this->assertSame(42084.0, $cost);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCostRefundTravelRoute()
    {
        $cost = $this->calculateCostTraveRouteByTypeTrip("Devolucion", TypeTrip::getTypeRefund());
        $this->assertSame(1000.0, $cost);
    }
  
}
