<?php

namespace Taisiya\PropelBundle\Database;

final class Schema
{
    /**
     * @var array
     */
    private $databases = [];

    /**
     * @param DatabaseInterface $database
     * @return self
     * @throws \InvalidArgumentException
     */
    final public function addDatabase(DatabaseInterface $database): self
    {
        if (array_key_exists($database->getName(), $this->databases)) {
            throw new \InvalidArgumentException('Database '.$database->getName().' already added');
        }

        $this->databases[$database->getName()] = $database;

        return $this;
    }

    /**
     * @param string $name
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    final public function getDatabase(string $name): DatabaseInterface
    {
        if (!array_key_exists($name, $this->databases)) {
            throw new \InvalidArgumentException('Database '.$name.' not added');
        }

        return $this->databases[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    final public function hasDatabase(string $name): bool
    {
        return array_key_exists($name, $this->databases);
    }

    /**
     * @return array
     */
    final public function getDatabases(): array
    {
        return $this->databases;
    }

    final public function writeToFile()
    {
        $database = $this->getDatabase(DefaultDatabase::NAME);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        $databaseElement = $dom->createElement('database');
        $databaseElement->setAttribute('name', $database->getName());
        $databaseElement->setAttribute('defaultIdMethod', $database->getDefaultIdMethod());

        $additionalProperties = [
            'package',
            'schema',
            'namespace',
            'baseClass',
            'defaultPhpNamingMethod',
            'heavyIndexing',
            'identifierQuoting',
            'tablePrefix',
        ];

        foreach ($additionalProperties as $propertyName) {
            $method = method_exists($database, 'get'.ucfirst($propertyName))
                ? 'get'.ucfirst($propertyName)
                : 'is'.ucfirst($propertyName);

            $propertyValue = $database->{$method}();
            if ($propertyValue != '') {
                $databaseElement->setAttribute($propertyName, $propertyValue);
            }
        }

        /** @var TableInterface $table */
        foreach ($database->getTables() as $table) {
            $tableElement = $dom->createElement('table');
            $tableElement->setAttribute('name', $table->getName());
            if ($table->getIdMethod() !== null) {
                $tableElement->setAttribute('idMethod', $table->getIdMethod());
            }
            $databaseElement->appendChild($tableElement);
        }

        $dom->appendChild($databaseElement);

        $dom->save(TAISIYA_ROOT.'/schema.xml');
    }
}
