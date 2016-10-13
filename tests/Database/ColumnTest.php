<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable\IdColumn;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable\FirstTestTableId;
use Taisiya\PropelBundle\Database\TestDatabase\TestColumn;
use Taisiya\PropelBundle\Database\TestDatabase\TestForeignKey;
use Taisiya\PropelBundle\PHPUnitTestCase;

class ColumnTest extends PHPUnitTestCase
{
    /**
     * @covers Column::getForeignKeys
     * @covers Column::getForeignKey
     * @covers Column::hasForeignKey
     * @covers Column::addForeignKey
     */
    public function testForeignKeys()
    {
        $column = new TestColumn();

        $foreignKey = new TestForeignKey(
            new SecondTestTable(),
            new ForeignKeyReference(new IdColumn(), new FirstTestTableId())
        );
        $column->addForeignKey($foreignKey);

        $this->assertCount(1, $column->getForeignKeys());
        $this->assertEquals($foreignKey, $column->getForeignKeys()[TestForeignKey::getName()]);
        $this->assertEquals($foreignKey, $column->getForeignKey(TestForeignKey::getName()));
        $this->assertTrue($column->hasForeignKey(TestForeignKey::getName()));
    }
}
