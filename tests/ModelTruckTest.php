<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\ModelTruck;

final class ModelTruckTest extends TestCase
{

    /**
     * Test create ModelTruck
     *
     * @return void
     */
    public function testCreateModelTruck()
    {
        $modelTruck = new ModelTruck("Model 1", 60.0, 2500.0);
        $data = $modelTruck->getProperties();

        $this->assertSame("Model 1", $data->name);
        $this->assertSame(60.0, $data->volume);
        $this->assertSame(2500.0, $data->maximumSupport);
    }
  
}
