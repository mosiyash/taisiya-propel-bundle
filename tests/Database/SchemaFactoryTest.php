<?php

namespace Taisiya\PropelBundle\Database;

class SchemaFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers SchemaFactory::create()
     */
    public function testCreate()
    {
        $schema = SchemaFactory::create();
        $this->assertInstanceOf(Schema::class, $schema);
    }
}
