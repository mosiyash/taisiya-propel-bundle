<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleTable\ExampleIndex;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleTable\IdColumn;
use Taisiya\PropelBundle\PHPUnitTestCase;

class IndexTest extends PHPUnitTestCase
{
    /**
     * @covers Index::addColumn()
     * @covers Index::addColumnIfNotExists()
     * @covers Index::getColumns()
     * @covers Index::findIndexColumnByName()
     * @covers Index::removeColumn()
     */
    public function testAll()
    {
        $index = new ExampleIndex();

        for ($i = 0; $i < 2; $i++) {
            try {
                $index->addColumn(new IdColumn());
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $index->getColumns());
            $this->assertInstanceOf(IdColumn::class, $index->getColumns()[0]->getColumn());
            $this->assertNull($index->findIndexColumnByName(IdColumn::getName())->getSize());
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $index->removeColumn(IdColumn::getName());
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $index->getColumns());
        }

        for ($i = 0; $i < 2; $i++) {
            $index->addColumnIfNotExists(new IdColumn(), 255);
            $this->assertCount(1, $index->getColumns());
            $this->assertInstanceOf(IdColumn::class, $index->getColumns()[0]->getColumn());
            $this->assertSame(255, $index->findIndexColumnByName(IdColumn::getName())->getSize());
        }

        $index->addColumnIfNotExists(new IdColumn(), 32);
        $this->assertCount(1, $index->getColumns());
        $this->assertInstanceOf(IdColumn::class, $index->getColumns()[0]->getColumn());
        $this->assertSame(32, $index->findIndexColumnByName(IdColumn::getName())->getSize());
    }
}
