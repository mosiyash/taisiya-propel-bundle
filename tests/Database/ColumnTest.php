<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\ExampleForeignTable\ForeignIdColumn;
use Taisiya\PropelBundle\Database\ExampleTable\IdColumn;
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
        $this->assertEquals($foreignKey, $column->getForeignKeys()[$foreignKey->getName()]);
        $this->assertEquals($foreignKey, $column->getForeignKey($foreignKey->getName()));
        $this->assertTrue($column->hasForeignKey($foreignKey->getName()));
    }
}
