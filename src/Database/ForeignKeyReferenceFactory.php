<?php

namespace Taisiya\PropelBundle\Database;

final class ForeignKeyReferenceFactory
{
    /**
     * @param ForeignKeyReference $foreignKeyReference
     * @return ForeignKeyReference
     */
    public function create(ForeignKeyReference $foreignKeyReference): ForeignKeyReference
    {
        return $foreignKeyReference;
    }
}
