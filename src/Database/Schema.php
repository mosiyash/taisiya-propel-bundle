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
     * @throws \InvalidArgumentException
     */
    public function addDatabase(DatabaseInterface $database)
    {
        if (array_key_exists($database->getName(), $this->databases)) {
            throw new \InvalidArgumentException('Database '.$database->getName().' already added');
        }

        $this->databases[$database->getName()] = $database;
    }

    /**
     * @param string $name
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    public function getDatabase(string $name): DatabaseInterface
    {
        if (!array_key_exists($name, $this->databases)) {
            throw new \InvalidArgumentException('Database '.$name.' not added');
        }

        return $this->databases[$name];
    }

    /**
     * @return array
     */
    public function getDatabases(): array
    {
        return $this->databases;
    }
}