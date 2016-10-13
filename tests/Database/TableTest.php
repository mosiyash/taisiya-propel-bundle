<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\TestColumn;
use Taisiya\PropelBundle\Database\TestDatabase\TestForeignKey;
use Taisiya\PropelBundle\PHPUnitTestCase;

class TableTest extends PHPUnitTestCase
{
    /**
     * @covers Table::createColumn
     * @covers Table::createColumnIfNotExists
     * @covers Table::getColumns
     * @covers Table::getColumn
     * @covers Table::hasColumn
     * @covers Table::removeColumn
     */
    public function testColumnMethods()
    {
        $table = new FirstTestTable();
        $this->assertCount(0, $table->getColumns());

        $column = new TestColumn();

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->createColumn($column);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }

            $this->assertCount(1, $table->getColumns());
            $this->assertEquals($column, $table->getColumns()[TestColumn::getName()]);
            $this->assertEquals($column, $table->getColumn(TestColumn::getName()));
            $this->assertTrue($table->hasColumn(TestColumn::getName()));
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
            $this->assertEquals($column, $table->getColumn(TestColumn::getName()));
        }
    }

    /**
     * @covers Table::addForeignKey
     * @covers Table::getForeignKeys
     * @covers Table::getForeignKey
     * @covers Table::hasForeignKey
     * @covers Table::removeForeignKey
     */
    public function testForeignKeyMethods()
    {
        $table = new FirstTestTable();
        $this->assertCount(0, $table->getForeignKeys());

        $foreignKey = new TestForeignKey(
            new SecondTestTable(),
            new ForeignKeyReference(new FirstTestTable\IdColumn(), new SecondTestTable\FirstTestTableId())
        );

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->addForeignKey($foreignKey);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $table->getForeignKeys());
            $this->assertInstanceOf(TestForeignKey::class, $table->getForeignKeys()[$foreignKey::getName()]);
            $this->assertInstanceOf(TestForeignKey::class, $table->getForeignKey($foreignKey::getName()));
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
     * @covers Table::addIndex
     * @covers Table::getIndexes
     * @covers Table::getIndex
     * @covers Table::hasIndex
     * @covers Table::removeIndex
     */
    public function testIndexMethods()
    {
        $table = new FirstTestTable();
        $this->assertCount(0, $table->getIndexes());

        $index = new FirstTestTable\TestIndex();

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->addIndex($index);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $table->getIndexes());
            $this->assertInstanceOf(FirstTestTable\TestIndex::class, $table->getIndexes()[$index::getName()]);
            $this->assertInstanceOf(FirstTestTable\TestIndex::class, $table->getIndex($index::getName()));
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

    /**
     * @covers Table::addUnique
     * @covers Table::getUniques
     * @covers Table::getUnique
     * @covers Table::hasUnique
     * @covers Table::removeUnique
     */
    public function testUniqueIndexMethods()
    {
        $table = new FirstTestTable();
        $this->assertCount(0, $table->getUniques());

        $index = new FirstTestTable\TestUniqueIndex();

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->addUnique($index);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $table->getUniques());
            $this->assertInstanceOf(FirstTestTable\TestUniqueIndex::class, $table->getUniques()[$index::getName()]);
            $this->assertInstanceOf(FirstTestTable\TestUniqueIndex::class, $table->getUnique($index::getName()));
            $this->assertTrue($table->hasUnique($index::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $table->removeUnique($index);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $table->getUniques());
        }
    }
}
