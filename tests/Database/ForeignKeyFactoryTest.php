<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\ExampleForeignTable\ForeignIdColumn;
use Taisiya\PropelBundle\Database\ExampleTable\IdColumn;
use Taisiya\PropelBundle\PHPUnitTestCase;

class ForeignKeyFactoryTest extends PHPUnitTestCase
{
    public function testCreate()
    {
        $exampleForeignKey = ForeignKeyFactory::create(
            new ExampleForeignKey(
                new ExampleForeignTable(),
                new ForeignKeyReference(new IdColumn(), new ForeignIdColumn())
            )
        );
        $this->assertInstanceOf(ForeignKey::class, $exampleForeignKey);
    }
}
