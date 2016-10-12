<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class DatabaseTest extends PHPUnitTestCase
{
    /**
     * @return Database
     */
    public function testConstruct()
    {
        $database = new ExampleDatabase();
        $this->assertInstanceOf(Database::class, $database);
        return $database;
    }

    /**
     * @depends testConstruct
     * @covers Schema::addTable()
     * @covers Schema::getTables()
     * @covers Schema::getTable()
     * @covers Schema::hasTable()
     */
    public function testTables()
    {
        /** @var Database $database */
        $database = func_get_arg(0);

        $table = new ExampleTable();
        $database->addTable(TableFactory::create($table));

        $this->assertCount(1, $database->getTables());
        $this->assertArrayHasKey(ExampleTable::getName(), $database->getTables());
        $this->assertEquals($table, $database->getTables()[ExampleTable::getName()]);
        $this->assertEquals($table, $database->getTable(ExampleTable::getName()));
        $this->assertTrue($database->hasTable(ExampleTable::getName()));
    }
}
