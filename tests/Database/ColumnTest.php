<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\TestDatabase\ExampleColumn;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignKey;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignTable;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleForeignTable\ForeignIdColumn;
use Taisiya\PropelBundle\Database\TestDatabase\ExampleTable\IdColumn;
use Taisiya\PropelBundle\PHPUnitTestCase;

class ColumnTest extends PHPUnitTestCase
{
    /**
     * @return Column
     */
    public function testConstruct()
    {
        $column = new ExampleColumn();
        $this->assertInstanceOf(Column::class, $column);
        return $column;
    }

    /**
     * @depends testConstruct
     */
    public function testForeignKeys()
    {
        /** @var ExampleColumn $column */
        $column = func_get_arg(0);

        $foreignKey = new ExampleForeignKey(
            new ExampleForeignTable(),
            new ForeignKeyReference(new IdColumn(), new ForeignIdColumn())
        );
        $column->addForeignKey($foreignKey);

        $this->assertCount(1, $column->getForeignKeys());
        $this->assertEquals($foreignKey, $column->getForeignKeys()[ExampleForeignKey::getName()]);
        $this->assertEquals($foreignKey, $column->getForeignKey(ExampleForeignKey::getName()));
        $this->assertTrue($column->hasForeignKey(ExampleForeignKey::getName()));
    }
}
