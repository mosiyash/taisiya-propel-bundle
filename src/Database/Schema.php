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
}
