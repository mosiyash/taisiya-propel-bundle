<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleColumn;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleTable;
use Taisiya\PropelBundle\PHPUnitTestCase;

class TableTest extends PHPUnitTestCase
{
    /**
     * @return Table
     */
    public function testConstruct()
    {
        $table = new ExampleTable();
        $this->assertInstanceOf(Table::class, $table);
        return $table;
    }

    /**
     * @depends testConstruct
     * @covers Table::createColumn()
     * @covers Table::createColumnIfNotExists()
     * @covers Table::getColumns()
     * @covers Table::getColumn()
     * @covers Table::hasColumn()
     * @covers Table::removeColumn()
     */
    public function testTables()
    {
        /** @var Table $table */
        $table = func_get_arg(0);
        $this->assertCount(0, $table->getColumns());

        $column = new ExampleColumn();

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->createColumn($column);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }

            $this->assertCount(1, $table->getColumns());
            $this->assertEquals($column, $table->getColumns()[ExampleColumn::getName()]);
            $this->assertEquals($column, $table->getColumn(ExampleColumn::getName()));
            $this->assertTrue($table->hasColumn(ExampleColumn::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->removeColumn($column);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $table->getColumns());
        }

        for ($i = 0; $i < 2; $i++) {
            $table->createColumnIfNotExists($column);
            $this->assertCount(1, $table->getColumns());
            $this->assertEquals($column, $table->getColumn(ExampleColumn::getName()));
        }
    }
}
