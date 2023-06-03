<?php

declare(strict_types=1);

require_once dirname(dirname(__FILE__)) . '\_autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\Package;

final class PackageTest extends TestCase
{

    /**
     * Test create Package
     *
     * @return void
     */
    public function testCreatePackage()
    {
        $package = new Package(1, 2, 3, 4, 1, false);
        $data = $package->getProperties();

        $this->assertSame(1.0, $data->weight);
        $this->assertSame(2.0, $data->tall);
        $this->assertSame(3.0, $data->long);
        $this->assertSame(4.0, $data->wide);
        $this->assertSame(1, $data->tripId);
        $this->assertSame(false, $data->delivered);
    }

}
