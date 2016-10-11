<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\ExampleForeignTable\ForeignIdColumn;
use Taisiya\PropelBundle\Database\ExampleTable\IdColumn;

class ForeignKeyReferenceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers SchemaFactory::create()
     */
    public function testCreate()
    {
        $foreignKeyReference = ForeignKeyReferenceFactory::create(
            new ForeignKeyReference(new IdColumn(), new ForeignIdColumn())
        );

        $this->assertInstanceOf(ForeignKeyReference::class, $foreignKeyReference);
        $this->assertInstanceOf(IdColumn::class, $foreignKeyReference->getLocalColumn());
        $this->assertInstanceOf(ForeignIdColumn::class, $foreignKeyReference->getForeignColumn());
    }
}
