<?php

namespace Taisiya\PropelBundle\Database;

final class IndexColumn
{
    /**
     * @var Column
     */
    private $column;

    /**
     * @var int|null
     */
    private $size = null;

    /**
     * IndexColumn constructor.
     * @param Column $column
     * @param int|null $size
     */
    public function __construct(Column $column, int $size = null)
    {
        $this->column = $column;
        $this->size = $size;
    }

    /**
     * @return Column
     */
    public function getColumn(): Column
    {
        return $this->column;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return IndexColumn
     */
    public function setSize(int $size = null): self
    {
        $this->size = $size;

        return $this;
    }
}
