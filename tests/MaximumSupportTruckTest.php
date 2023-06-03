<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Helpers\PackageHelper;
use src\Models\ModelTruck;
use src\Models\Truck;
use src\Models\Address;
use src\Models\TravelRoute;
use src\Models\TypeTrip;
use src\Models\Trip;
use src\Models\Package;
use src\Models\TravelRouteTruck;

use src\Helpers\TravelRouteTruckHelper;

final class MaximumSupportTruckTest extends TestCase
{

    protected array $storage;
    protected int $storageAutoIncrement = 0;

    protected array $packages;
    protected array $trips;

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

    private function setAndGetObjectInStorage($object): array
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
     * @return array
     */
    private function generateTravelRouteData(): array
    {
        $initDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime(date('Y-m-d'). " + 3 day"));
        $travelRouteChildrenId = 0;
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

    

    public function testValidateMaximumSupportSuccess()
    {
        list($addressInitId, $addressInitData) = $this->generateAddressData("Wilde", -34.7066528, -58.3428114);
        list($addressEndId, $addressEndData) = $this->generateAddressData("Hospital Italiano de Buenos Aires", -34.592662, -58.431068);
        list($travelRouteId, $travelRouteData) = $this->generateTravelRouteData();
        list($modelTruckId, $modelTruckData) = $this->generateModelTruckData("Model 1", 60.0, 2000);
        list($typeTripId, $typeTripData) = $this->generateTypeTripData("Prioritario", TypeTrip::getTypeNormal());
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

        $truck = new Truck($modelTruckId, "AC200LC");
        list($truckId, $truckData) = $this->setAndGetObjectInStorage($truck);

        $validateMaximumSupport = true;
        $validateMaximumSupportMessage = "";
        try{
            $maximumSupportByModelTruck = $this->storage[$truckData->modelId]->maximumSupport;
            $validateMaximumSupport = TravelRouteTruckHelper::validateMaximumSupport($maximumSupportByModelTruck, $totalWeightPackages);
        } catch(Exception $e) {
            $validateMaximumSupport = false;
            $validateMaximumSupportMessage = $e->getMessage();
        }

        if($validateMaximumSupport) {
            $travelRouteTruck = new TravelRouteTruck($truckId, $travelRouteId);
            list($travelRouteTruckId, $travelRouteTruckData) = $this->setAndGetObjectInStorage($travelRouteTruck);
        }

        $this->assertTrue($validateMaximumSupport, $validateMaximumSupportMessage);
    }

    public function testValidateMaximumSupportError()
    {
        list($addressInitId, $addressInitData) = $this->generateAddressData("Wilde", -34.7066528, -58.3428114);
        list($addressEndId, $addressEndData) = $this->generateAddressData("Hospital Italiano de Buenos Aires", -34.592662, -58.431068);
        list($travelRouteId, $travelRouteData) = $this->generateTravelRouteData();
        list($modelTruckId, $modelTruckData) = $this->generateModelTruckData("Model 1", 60.0, 100);
        list($typeTripId, $typeTripData) = $this->generateTypeTripData("Prioritario", TypeTrip::getTypeNormal());
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

        $truck = new Truck($modelTruckId, "AC200LC");
        list($truckId, $truckData) = $this->setAndGetObjectInStorage($truck);

        $validateMaximumSupport = true;
        $validateMaximumSupportMessage = "";
        try{
            $maximumSupportByModelTruck = $this->storage[$truckData->modelId]->maximumSupport;
            $validateMaximumSupport = TravelRouteTruckHelper::validateMaximumSupport($maximumSupportByModelTruck, $totalWeightPackages);
        } catch(Exception $e) {
            $validateMaximumSupport = false;
            $validateMaximumSupportMessage = $e->getMessage();
        }

        if($validateMaximumSupport) {
            $travelRouteTruck = new TravelRouteTruck($truckId, $travelRouteId);
            list($travelRouteTruckId, $travelRouteTruckData) = $this->setAndGetObjectInStorage($travelRouteTruck);
        }

        $this->assertFalse($validateMaximumSupport, $validateMaximumSupportMessage);
    }
  
}
