<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;
use Taisiya\PropelBundle\Database\TestDatabase\FirstTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\SecondTestTable;
use Taisiya\PropelBundle\Database\TestDatabase\TestDatabase;
use Taisiya\PropelBundle\PHPUnitTestCase;
use Taisiya\PropelBundle\XMLAssertsTrait;

class SchemaTest extends PHPUnitTestCase
{
    use XMLAssertsTrait;

    /**
     * @covers Schema::createDatabase
     * @covers Schema::getDatabases
     * @covers Schema::getDatabase
     * @covers Schema::hasDatabase
     * @covers Schema::removeDatabase
     * @covers Schema::createDatabaseIfNotExists
     */
    public function testCreateDatabase()
    {
        $schema = new Schema();
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
     * @covers Schema::generateOutputXml
     * @covers Database::appendToXmlDocument
     * @covers Table::appendToXmlDocument
     * @covers Column::appendToXmlDocument
     * @covers Index::appendToXmlDocument
     * @covers IndexColumn::appendToXmlDocument
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

        $secondTable = $database->createTableIfNotExists(new SecondTestTable())
            ->getTable(SecondTestTable::getName());

        $xml = $schema->generateOutputXml();
        $this->assertXmlHasProlog($xml);

        $this->assertXmlHasElements($xml, '/database', 1);
        $this->assertXmlHasElements($xml, '/database/table', 2);
        $this->assertXmlHasElements($xml, '/database/table[@name="first"]/column', 3);
        $this->assertXmlHasElements($xml, '/database/table[@name="first"]/index', 1);
        $this->assertXmlHasElements($xml, '/database/table[@name="first"]/index/index-column', 2);
        $this->assertXmlHasElements($xml, '/database/table[@name="first"]/unique', 1);
        $this->assertXmlHasElements($xml, '/database/table[@name="first"]/unique/unique-column', 2);
    }
}
