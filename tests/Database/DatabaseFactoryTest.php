<?php

namespace Taisiya\PropelBundle\Database;

class DatabaseFactoryTest extends \PHPUnit_Framework_TestCase
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
