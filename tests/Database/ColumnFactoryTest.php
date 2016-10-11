<?php

namespace Taisiya\PropelBundle\Database;

class ColumnFactoryTest extends \PHPUnit_Framework_TestCase
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
