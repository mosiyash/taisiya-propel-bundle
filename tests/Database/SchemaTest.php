<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
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
     * @covers Schema::createDatabase()
     * @covers Schema::getDatabases()
     * @covers Schema::getDatabase()
     * @covers Schema::hasDatabase()
     * @covers Schema::removeDatabase()
     * @covers Schema::createDatabaseIfNotExists()
     */
    public function testCreateDatabase()
    {
        /** @var Schema $schema */
        $schema = func_get_arg(0);
        $this->assertCount(0, $schema->getDatabases());

        $database = new ExampleDatabase();

        for ($i = 0; $i < 2; $i++) {
            try {
                $schema->createDatabase($database);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $schema->getDatabases());
            $this->assertEquals($database, $schema->getDatabases()[ExampleDatabase::getName()]);
            $this->assertEquals($database, $schema->getDatabase(ExampleDatabase::getName()));
            $this->assertTrue($schema->hasDatabase(ExampleDatabase::getName()));
        }

        for ($i = 0; $i < 2; $i++) {
            try {
                $schema->removeDatabase($database);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(0, $schema->getDatabases());
        }

        for ($i = 0; $i < 2; $i++) {
            $schema->createDatabaseIfNotExists($database);
            $this->assertCount(1, $schema->getDatabases());
            $this->assertTrue($schema->hasDatabase(ExampleDatabase::getName()));
        }
    }

    public function testWriteToFile()
    {
        //        $schema = SchemaFactory::create();
//        $schema->createDatabase(new ExampleDatabase());
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
