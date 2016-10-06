<?php

namespace Taisiya\PropelBundle\Database;

final class SchemaFactory
{
    /**
     * @return Schema
     */
    public static function create(): Schema
    {
        return new Schema();
    }
}
