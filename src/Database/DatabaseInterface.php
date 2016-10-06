<?php

namespace Taisiya\PropelBundle\Database;

interface DatabaseInterface
{
    /**
     * DatabaseInterface constructor.
     * @param string $defaultIdMethod
     */
    public function __construct(string $defaultIdMethod = AbstractDatabase::DEFAULT_ID_METHOD_NATIVE);

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
