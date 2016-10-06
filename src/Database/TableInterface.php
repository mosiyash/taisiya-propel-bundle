<?php

namespace Taisiya\PropelBundle\Database;

interface TableInterface
{
    /**
     * The database name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getIdMethod(): string;

    /**
     * @param string $idMethod
     * @return TableInterface
     */
    public function setIdMethod(string $idMethod): self;

    /**
     * @return string
     */
    public function getPhpName(): string;

    /**
     * @param ColumnInterface $column
     * @return TableInterface
     */
    public function addColumn(ColumnInterface $column): self;

    /**
     * @param string $name
     * @return ColumnInterface
     */
    public function getColumn(string $name): ColumnInterface;

    /**
     * @return array
     */
    public function getColumns(): array;
}
