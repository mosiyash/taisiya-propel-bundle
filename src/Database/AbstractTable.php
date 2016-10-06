<?php

namespace Taisiya\PropelBundle\Database;

abstract class AbstractTable implements TableInterface
{
    /**
     * @var string
     */
    private $idMethod;

    /**
     * @var string
     */
    private $phpName;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @return string
     */
    final public function getIdMethod(): string
    {
        return $this->idMethod;
    }

    /**
     * @param string $idMethod
     * @return TableInterface
     * @throws \InvalidArgumentException
     */
    final public function setIdMethod(string $idMethod): TableInterface
    {
        if (!in_array($idMethod, ['native', 'none'])) {
            throw new \InvalidArgumentException('Invalid idMethod value');
        }

        $this->idMethod = $idMethod;

        return $this;
    }

    /**
     * @return string
     */
    final public function getPhpName(): string
    {
        return $this->phpName;
    }

    /**
     * @param string $phpName
     */
    final public function setPhpName(string $phpName)
    {
        $this->phpName = $phpName;
    }

    /**
     * @param ColumnInterface $column
     * @return TableInterface
     * @throws \InvalidArgumentException
     */
    public function addColumn(ColumnInterface $column): TableInterface
    {
        if (array_key_exists($column->getName(), $this->columns)) {
            throw new \InvalidArgumentException('Column '.$column->getName().' already added');
        }

        $this->columns[$column->getName()] = $column;

        return $this;
    }

    /**
     * @param string $name
     * @return ColumnInterface
     * @throws \InvalidArgumentException
     */
    public function getColumn(string $name): ColumnInterface
    {
        if (!array_key_exists($name, $this->tables)) {
            throw new \InvalidArgumentException('Column '.$name.' not added');
        }

        return $this->tables[$name];
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->tables;
    }
}
