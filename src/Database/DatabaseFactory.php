<?php

namespace Taisiya\PropelBundle\Database;

final class DatabaseFactory
{
    /**
     * @param Database $database
     * @return Database
     */
    public static function create(Database $database): Database
    {
        return $database;
    }
}
