<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\Truck;

final class TruckTest extends TestCase
{

    /**
     * Test create truck
     *
     * @return void
     */
    public function testCreateTruck()
    {
        $truck = new Truck(1,"AC200LC");
        $data = $truck->getProperties();

        $this->assertSame(1, $data->modelId);
        $this->assertSame("AC200LC", $data->patent);
    }
  
}
