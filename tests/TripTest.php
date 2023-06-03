<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\Trip;

final class TripTest extends TestCase
{

    /**
     * Test create Trip
     *
     * @return void
     */
    public function testCreateTrip()
    {
        $trip = new Trip(1, 2, 1, false, 1);
        $data = $trip->getProperties();
        
        $this->assertSame(1, $data->originId);
        $this->assertSame(2, $data->destinationId);
        $this->assertSame(1, $data->typePriority);
        $this->assertSame(false, $data->ended);
        $this->assertSame(1, $data->travelRouteId);
    }
  
}
