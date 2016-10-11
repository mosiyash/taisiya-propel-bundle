<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class ColumnFactoryTest extends PHPUnitTestCase
{
    /**
     * @covers ColumnFactory::create()
     */
    public function testCreate()
    {
        $database = ColumnFactory::create(new ExampleColumn());
        $this->assertInstanceOf(Column::class, $database);
        $this->assertInstanceOf(ExampleColumn::class, $database);
    }
}
