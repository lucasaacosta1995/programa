<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\TravelRoute;

final class TravelRouteTest extends TestCase
{

    /**
     * Test create TravelRoute
     *
     * @return void
     */
    public function testCreateTravelRoute()
    {
        $initDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime(date('Y-m-d'). " + 3 day"));
        $travelRouteChildrenId = 0;

        $travelRoute = new TravelRoute($initDate, $endDate, $travelRouteChildrenId);
        $data = $travelRoute->getProperties();

        $this->assertSame($initDate, $data->initDate);
        $this->assertSame($endDate, $data->endDate);
        $this->assertSame($travelRouteChildrenId, $data->travelRouteChildrenId);
    }
    
}
