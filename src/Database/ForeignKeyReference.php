<?php

namespace Taisiya\PropelBundle\Database;

final class ForeignKeyReference
{
    /**
     * @var Column
     */
    private $localColumn;

    /**
     * @var Column
     */
    private $foreignColumn;

    /**
     * ForeignKeyReference constructor.
     * @param Column $localColumn
     * @param Column $foreignColumn
     */
    public function __construct(Column $localColumn, Column $foreignColumn)
    {
        $this->localColumn = $localColumn;
        $this->foreignColumn = $foreignColumn;
    }

    /**
     * @return Column
     */
    public function getLocalColumn(): Column
    {
        return $this->localColumn;
    }

    /**
     * @return Column
     */
    public function getForeignColumn(): Column
    {
        return $this->foreignColumn;
    }
}
