<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class DatabaseFactoryTest extends PHPUnitTestCase
{
    /**
     * @covers DatabaseFactory::create()
     */
    public function testCreate()
    {
        $database = DatabaseFactory::create(new ExampleDatabase());
        $this->assertInstanceOf(Database::class, $database);
        $this->assertInstanceOf(ExampleDatabase::class, $database);
    }
}
