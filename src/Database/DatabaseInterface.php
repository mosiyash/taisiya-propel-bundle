<?php

namespace Taisiya\PropelBundle\Database;

interface DatabaseInterface
{
    /**
     * The database name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @param TableInterface $table
     * @return DatabaseInterface
     */
    public function addTable(TableInterface $table): self;

    /**
     * @param string $name
     * @return TableInterface
     */
    public function getTable(string $name): TableInterface;

    /**
     * @return array
     */
    public function getTables(): array;
}
