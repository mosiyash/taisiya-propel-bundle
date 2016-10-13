<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\TestDatabase;
use Taisiya\PropelBundle\PHPUnitTestCase;
use Taisiya\PropelBundle\XMLAssertsTrait;

class SchemaTest extends PHPUnitTestCase
{
    use XMLAssertsTrait;

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

        $database = new TestDatabase();

        for ($i = 0; $i < 2; $i++) {
            try {
                $schema->createDatabase($database);
            } catch (InvalidArgumentException $e) {
                $this->assertGreaterThan(0, $i);
            }
            $this->assertCount(1, $schema->getDatabases());
            $this->assertEquals($database, $schema->getDatabases()[TestDatabase::getName()]);
            $this->assertEquals($database, $schema->getDatabase(TestDatabase::getName()));
            $this->assertTrue($schema->hasDatabase(TestDatabase::getName()));
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
            $this->assertTrue($schema->hasDatabase(TestDatabase::getName()));
        }
    }

    /**
     * @covers Schema::generateOutputXml()
     */
    public function testGenerateOutputXml()
    {
        $schema = new Schema();

        $database = $schema->createDatabaseIfNotExists(new TestDatabase())
            ->getDatabase(TestDatabase::getName());

        $firstTable = $database->createTableIfNotExists(new FirstTestTable())
            ->getTable(FirstTestTable::getName())
            ->createColumnIfNotExists(new FirstTestTable\IdColumn())
            ->createColumnIfNotExists(new FirstTestTable\SecondColumn())
            ->createColumnIfNotExists(new FirstTestTable\ThirdColumn());

        $firstTableIndex = $firstTable->addIndex(new FirstTestTable\TestIndex())
            ->getIndex(FirstTestTable\TestIndex::getName())
            ->addColumnIfNotExists(new FirstTestTable\IdColumn())
            ->addColumnIfNotExists(new FirstTestTable\SecondColumn(), 32);

        $firstTableUniqueIndex = $firstTable->addUnique(new FirstTestTable\TestUniqueIndex())
            ->getUnique(FirstTestTable\TestUniqueIndex::getName())
            ->addColumnIfNotExists(new FirstTestTable\IdColumn(), 1)
            ->addColumnIfNotExists(new FirstTestTable\SecondColumn(), 1);

        $xml = $schema->generateOutputXml();
        $this->assertXmlHasProlog($xml);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($xml);
        //exit(var_dump($xml));
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
