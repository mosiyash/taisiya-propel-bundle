<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\PHPUnitTestCase;

class SchemaTest extends PHPUnitTestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (file_exists($this->getTmpSchemaFilepath())) {
            unlink($this->getTmpSchemaFilepath());
        }
    }

    protected function tearDown()
    {
        if (file_exists($this->getTmpSchemaFilepath())) {
            unlink($this->getTmpSchemaFilepath());
        }
    }

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

    public function testWriteToFile()
    {
//        $schema = SchemaFactory::create();
//        $schema->addDatabase(new ExampleDatabase());
//        $schema->writeToFile($this->getTmpSchemaFilepath());

        // TODO: write tests
    }

    /**
     * @return string
     */
    private function getTmpSchemaFilepath()
    {
        $filepath = TAISIYA_ROOT.'/var/tmp/schema.xml';
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0777, true);
        }
        return $filepath;
    }
}
