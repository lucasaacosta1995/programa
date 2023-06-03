<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\TravelRouteTruck;

final class TravelRouteTruckTest extends TestCase
{

    /**
     * Test create TravelRouteTruck
     *
     * @return void
     */
    public function testCreateTravelRouteTruck()
    {
        $travelRouteTruck = new TravelRouteTruck(1, 1);
        $data = $travelRouteTruck->getProperties();

        $this->assertSame(1, $data->truckId);
        $this->assertSame(1, $data->travelRouteId);
    }
    
}
