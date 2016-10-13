<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleDatabase;
use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;
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
     * @covers Database::createTable()
     * @covers Database::createTableIfNotExists()
     * @covers Database::getTables()
     * @covers Database::getTable()
     * @covers Database::hasTable()
     * @covers Database::removeTable()
     */
    public function testTables()
    {
        /** @var Database $database */
        $database = func_get_arg(0);
        $this->assertCount(0, $database->getTables());

        $table = new FirstTestTable();

        for ($i = 0; $i < 2; $i++) {
            try {
                $database->createTable($table);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }

            $this->assertCount(1, $database->getTables());
            $this->assertEquals($table, $database->getTables()[FirstTestTable::getName()]);
            $this->assertEquals($table, $database->getTable(FirstTestTable::getName()));
            $this->assertTrue($database->hasTable(FirstTestTable::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $database->removeTable($table);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $database->getTables());
        }

        for ($i = 0; $i < 2; $i++) {
            $database->createTableIfNotExists($table);
            $this->assertCount(1, $database->getTables());
            $this->assertEquals($table, $database->getTable(FirstTestTable::getName()));
        }
    }
}
