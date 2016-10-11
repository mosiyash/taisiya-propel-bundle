<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\ExampleForeignTable\ForeignIdColumn;
use Taisiya\PropelBundle\Database\ExampleTable\IdColumn;
use Taisiya\PropelBundle\PHPUnitTestCase;

class ForeignKeyTest extends PHPUnitTestCase
{
    /**
     * @covers ForeignKey::getForeignTable()
     * @covers ForeignKey::getForeignKeyReference()
     * @return ExampleForeignKey
     */
    public function testConstruct()
    {
        $foreignKey = new ExampleForeignKey(
            new ExampleForeignTable(),
            new ForeignKeyReference(new IdColumn(), new ForeignIdColumn())
        );
        $this->assertInstanceOf(ForeignKey::class, $foreignKey);
        $this->assertInstanceOf(Table::class, $foreignKey->getForeignTable());
        
        return $foreignKey;
    }
}
