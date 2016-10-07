<?php

namespace Taisiya\PropelBundle\Database;

abstract class AbstractDatabase implements DatabaseInterface
{
    const DEFAULT_ID_METHOD_NATIVE = 'native';
    const DEFAULT_ID_METHOD_NONE = 'none';

    /**
     * @var string
     */
    private $defaultIdMethod;

    /**
     * @var array
     */
    private $tables = [];

    /**
     * AbstractDatabase constructor.
     * @param string $defaultIdMethod
     * @throws \InvalidArgumentException
     */
    final public function __construct(string $defaultIdMethod = self::DEFAULT_ID_METHOD_NATIVE)
    {
        if (!in_array($defaultIdMethod, [self::DEFAULT_ID_METHOD_NATIVE, self::DEFAULT_ID_METHOD_NONE])) {
            throw new \InvalidArgumentException('Incorrect value for defaultIdValue');
        }

        $this->defaultIdMethod = $defaultIdMethod;
    }

    /**
     * @return string
     */
    public function getDefaultIdMethod(): string
    {
        return $this->defaultIdMethod;
    }

    /**
     * @param TableInterface $table
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    public function addTable(TableInterface $table): Databaseinterface
    {
        if (array_key_exists($table->getName(), $this->tables)) {
            throw new \InvalidArgumentException('Table '.$table->getName().' already added');
        }

        $this->tables[$table->getName()] = $table;

        return $this;
    }

    /**
     * @param string $name
     * @return TableInterface
     * @throws \InvalidArgumentException
     */
    public function getTable(string $name): TableInterface
    {
        if (!array_key_exists($name, $this->tables)) {
            throw new \InvalidArgumentException('Table '.$name.' not added');
        }

        return $this->tables[$name];
    }

    /**
     * @return array
     */
    public function getTables(): array
    {
        return $this->tables;
    }
}
