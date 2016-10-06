<?php

namespace Taisiya\PropelBundle\Database;

final class ColumnFactory
{
    /**
     * @param $columnClass
     * @return ColumnInterface
     * @throws \InvalidArgumentException
     */
    public static function create($columnClass): ColumnInterface
    {
        $obj = new $columnClass;

        if (!$obj instanceof ColumnInterface) {
            throw new \InvalidArgumentException('Column class must be instance of '.ColumnInterface::class);
        }

        return $obj;
    }
}
