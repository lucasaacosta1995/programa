<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\Address;

final class AddressTest extends TestCase
{

    /**
     * Test create address
     *
     * @return void
     */
    public function testCreateAddress()
    {
        $address = new Address("Buenos Aires", -34.6131500, -58.3772300);
        $data = $address->getProperties();

        $this->assertSame("Buenos Aires", $data->name);
        $this->assertSame(-34.6131500, $data->latitude);
        $this->assertSame(-58.3772300, $data->longitude);
    }
  
}
