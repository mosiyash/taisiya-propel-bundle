<?php

namespace Taisiya\PropelBundle\Database;

final class DatabaseFactory
{
    /**
     * @param $databaseClass
     * @param string $defaultIdMethod
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    public static function create($databaseClass, string $defaultIdMethod = AbstractDatabase::ID_METHOD_NATIVE): DatabaseInterface
    {
        $obj = new $databaseClass($defaultIdMethod);

        if (!$obj instanceof DatabaseInterface) {
            throw new \InvalidArgumentException('Database class must be instance of '.DatabaseInterface::class);
        }

        return $obj;
    }
}
