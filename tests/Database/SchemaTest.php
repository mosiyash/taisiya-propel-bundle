<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class SchemaTest extends PHPUnitTestCase
{
    /**
     * @return Schema
     */
    public function testConstruct()
    {
        $schema = new Schema();
        $this->assertInstanceOf(Schema::class, $schema);
        return $schema;
    }

    /**
     * @depends testConstruct
     * @covers Schema::addDatabase()
     * @covers Schema::getDatabases()
     * @covers Schema::getDatabase()
     * @covers Schema::hasDatabase()
     */
    public function testDatabases()
    {
        /** @var Schema $schema */
        $schema = func_get_arg(0);

        $database = new ExampleDatabase();
        $schema->addDatabase(DatabaseFactory::create($database));

        $this->assertCount(1, $schema->getDatabases());
        $this->assertArrayHasKey($database->getName(), $schema->getDatabases());
        $this->assertEquals($database, $schema->getDatabases()[$database->getName()]);
        $this->assertEquals($database, $schema->getDatabase($database->getName()));
        $this->assertTrue($schema->hasDatabase($database->getName()));
    }

    /**
     * @depends testConstruct
     */
    public function testWriteToFile()
    {
        /** @var Schema $schema */
        $schema = func_get_arg(0);
        $schema->addDatabase(new DefaultDatabase());
        $schema->writeToFile();
    }
}
