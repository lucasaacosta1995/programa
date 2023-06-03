<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\TypeTrip;

final class TypeTripTest extends TestCase
{

    /**
     * Test create TypeTrip
     *
     * @return void
     */
    public function testCreateTypeTrip()
    {
        $typeTrip = new TypeTrip("Normal", TypeTrip::getTypeNormal());
        $data = $typeTrip->getProperties();

        $this->assertSame("Normal", $data->name);
        $this->assertSame(TypeTrip::getTypeNormal(), $data->slug);
    }
  
}
