<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;

trait IndexTrait
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * @param Column $column
     * @param int|null $size
     * @return Index
     */
    final public function addColumn(Column $column, int $size = null): Index
    {
        if ($this->hasColumn($column::getName())) {
            throw new InvalidArgumentException('Column '.$column::getName().' already added to the index');
        }

        $this->columns[] = new IndexColumn($column, $size);

        return $this;
    }

    /**
     * @param Column $column
     * @param int|null $size
     * @return Index
     */
    final public function addColumnIfNotExists(Column $column, int $size = null): Index
    {
        if (!$this->hasColumn($column::getName())) {
            $this->addColumn($column, $size);
        } else {
            $indexColumn = $this->findIndexColumnByName($column::getName());
            if ($indexColumn->getSize() !== $size) {
                $indexColumn->setSize($size);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    final public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param string $name
     * @return bool
     */
    final public function hasColumn(string $name): bool
    {
        return (bool) $this->findIndexColumnByName($name);
    }

    /**
     * @param string $name
     * @return Index
     */
    final public function removeColumn(string $name): Index
    {
        if (!$this->hasColumn($name)) {
            throw new InvalidArgumentException('Index not contains the column '.$name);
        }

        $this->columns = array_filter(
            $this->columns,
            function (IndexColumn $indexColumn) use ($name) {
                $column = $indexColumn->getColumn();
                return (bool) ($column::getName() !== $name);
            }
        );

        return $this;
    }

    /**
     * @param string $name
     * @return null|IndexColumn
     */
    final public function findIndexColumnByName(string $name): ?IndexColumn
    {
        /** @var IndexColumn $indexColumn */
        foreach ($this->columns as $indexColumn) {
            $column = $indexColumn->getColumn();
            if ($column::getName() === $name) {
                return $indexColumn;
            }
        }

        return null;
    }
}
