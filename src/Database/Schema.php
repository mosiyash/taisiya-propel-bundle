<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;

final class Schema
{
    /**
     * @var array
     */
    private $databases = [];

    /**
     * @param Database $database
     * @return self
     * @throws InvalidArgumentException
     */
    public function createDatabase(Database $database): self
    {
        if ($this->hasDatabase($database::getName())) {
            throw new InvalidArgumentException('Database '.$database::getName().' already added');
        }

        $this->databases[$database::getName()] = $database;

        return $this;
    }

    /**
     * @param Database $database
     * @return Schema
     */
    public function createDatabaseIfNotExists(Database $database): self
    {
        if (!$this->hasDatabase($database::getName())) {
            $this->createDatabase($database);
        }

        return $this;
    }

    /**
     * @param Database $database
     * @throws InvalidArgumentException
     * @return Schema
     */
    public function removeDatabase(Database $database): self
    {
        if (!$this->hasDatabase($database::getName())) {
            throw new InvalidArgumentException('Database '.$database::getName().' not exists');
        }

        unset($this->databases[$database::getName()]);

        return $this;
    }

    /**
     * @param string $name
     * @return Database
     * @throws InvalidArgumentException
     */
    public function getDatabase(string $name): Database
    {
        if (!array_key_exists($name, $this->databases)) {
            throw new InvalidArgumentException('Database '.$name.' not added');
        }

        return $this->databases[$name];
    }

    public function getDatabaseByClassName(string $class): Database
    {
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasDatabase(string $name): bool
    {
        return array_key_exists($name, $this->databases);
    }

    public function hasDatabaseByClassName(string $className): bool
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException('Class '.$className.' not exists.');
        }
        $reflectionClass = new \ReflectionClass($className);
        if (!$reflectionClass->isSubclassOf(Database::class)) {
            throw new InvalidArgumentException('Class must be instance of '.Database::class.'.');
        }
        $name = $reflectionClass->getMethod('getName')->invoke($reflectionClass);
        exit(var_dump($name));
    }

    /**
     * @return array
     */
    public function getDatabases(): array
    {
        return $this->databases;
    }

    /**
     * @return string
     */
    final public function generateOutputXml(): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        /** @var Database $database */
        foreach ($this->getDatabases() as $database) {
            $database->appendToXmlDocument($dom);
        }

        return $dom->saveXML();
    }
}
