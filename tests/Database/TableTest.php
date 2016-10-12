<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleColumn;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignKey;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignTable;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleTable;
use Taisiya\PropelBundle\PHPUnitTestCase;

class TableTest extends PHPUnitTestCase
{

    /**
     * @covers Table::createColumn()
     * @covers Table::createColumnIfNotExists()
     * @covers Table::getColumns()
     * @covers Table::getColumn()
     * @covers Table::hasColumn()
     * @covers Table::removeColumn()
     */
    public function testColumnMethods()
    {
        $table = new ExampleTable();
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

    /**
     * @covers Table::addForeignKey()
     * @covers Table::getForeignKeys()
     * @covers Table::getForeignKey()
     * @covers Table::hasForeignKey()
     * @covers Table::removeForeignKey()
     */
    public function testForeignKeyMethods()
    {
        $table = new ExampleTable();
        $this->assertCount(0, $table->getForeignKeys());

        $foreignKey = new ExampleForeignKey(
            new ExampleForeignTable(),
            new ForeignKeyReference(new ExampleTable\IdColumn(), new ExampleForeignTable\ForeignIdColumn())
        );

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->addForeignKey($foreignKey);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $table->getForeignKeys());
            $this->assertInstanceOf(ExampleForeignKey::class, $table->getForeignKeys()[$foreignKey::getName()]);
            $this->assertInstanceOf(ExampleForeignKey::class, $table->getForeignKey($foreignKey::getName()));
            $this->assertTrue($table->hasForeignKey($foreignKey::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->removeForeignKey($foreignKey);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $table->getForeignKeys());
        }
    }

    /**
     * @covers Table::addForeignKey()
     * @covers Table::getForeignKeys()
     * @covers Table::getForeignKey()
     * @covers Table::hasForeignKey()
     * @covers Table::removeForeignKey()
     */
    public function testIndexMethods()
    {
        $table = new ExampleTable();
        $this->assertCount(0, $table->getIndexes());

        $index = new ExampleTable\ExampleIndex();

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->addIndex($index);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $table->getIndexes());
            $this->assertInstanceOf(ExampleTable\ExampleIndex::class, $table->getIndexes()[$index::getName()]);
            $this->assertInstanceOf(ExampleTable\ExampleIndex::class, $table->getIndex($index::getName()));
            $this->assertTrue($table->hasIndex($index::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->removeIndex($index);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $table->getIndexes());
        }
    }
}
