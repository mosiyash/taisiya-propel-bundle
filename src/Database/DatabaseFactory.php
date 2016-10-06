<?php

namespace Taisiya\PropelBundle\Database;

final class DatabaseFactory
{
    /**
     * @param $databaseClass
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    public static function create($databaseClass): DatabaseInterface
    {
        $obj = new $databaseClass;

        if (!$obj instanceof DatabaseInterface) {
            throw new \InvalidArgumentException('Database class must be instance of '.DatabaseInterface::class);
        }

        return $obj;
    }
}
