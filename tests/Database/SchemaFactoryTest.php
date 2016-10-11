<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class SchemaFactoryTest extends PHPUnitTestCase
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
