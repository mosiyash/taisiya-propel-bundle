<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable\IdColumn;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable\FirstTestTableId;
use Taisiya\PropelBundle\Database\TestDatabase\TestForeignKey;
use Taisiya\PropelBundle\PHPUnitTestCase;

class ForeignKeyTest extends PHPUnitTestCase
{
    /**
     * @covers ForeignKey::getForeignTable
     * @covers ForeignKey::getForeignKeyReference
     * @return TestForeignKey
     */
    public function testConstruct()
    {
        $foreignKey = new TestForeignKey(
            new SecondTestTable(),
            new ForeignKeyReference(new IdColumn(), new FirstTestTableId())
        );
        $this->assertInstanceOf(ForeignKey::class, $foreignKey);
        $this->assertInstanceOf(Table::class, $foreignKey->getForeignTable());
        
        return $foreignKey;
    }
}
