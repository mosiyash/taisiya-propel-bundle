<?php

namespace Taisiya\PropelBundle\Database;

interface ColumnInterface
{
    public function getName(): string;

    public function getPhpName() : ?string;

    public function setPhpName(string $phpName = null) : ColumnInterface;

    public function getTableMapName() : ?string;

    public function setTableMapName(string $tableMapName = null) : ColumnInterface;

    public function isPrimaryKey() : bool;

    public function setPrimaryKey(bool $primaryKey) : ColumnInterface;

    public function isRequired() : bool;

    public function setRequired(bool $required) : ColumnInterface;

    public function getType() : ?string;

    public function setType(string $type = null) : ColumnInterface;

    public function getPhpType() : ?string;

    public function setPhpType(string $phpType = null) : ColumnInterface;

    public function getSqlType() : ?string;

    public function setSqlType(string $sqlType = null) : ColumnInterface;

    public function getSize() : ?int;

    public function setSize(int $size = null) : ColumnInterface;

    public function getScale() : ?int;

    public function setScale(int $scale = null) : ColumnInterface;

    public function getDefaultvalue() : ?string;

    public function setDefaultvalue(string $defaultvalue = null) : ColumnInterface;

    public function getDefaultExpr() : ?string;

    public function setDefaultExpr(string $defaultExpr = null) : ColumnInterface;

    public function getValueSet() : ?string;

    public function setValueSet(string $valueSet = null) : ColumnInterface;

    public function isAutoIncrement() : bool;

    public function setAutoIncrement(bool $autoIncrement) : ColumnInterface;

    public function isLazyLoad() : bool;

    public function setLazyLoad(bool $lazyLoad) : ColumnInterface;

    public function getDescription() : ?string;

    public function setDescription(string $description = null) : ColumnInterface;

    public function isPrimaryString() : bool;

    public function setPrimaryString(bool $primaryString) : ColumnInterface;

    public function getPhpNamingMethod() : string;

    public function setPhpNamingMethod(string $phpNamingMethod) : ColumnInterface;

    public function getInheritance() : ?string;

    public function setInheritance(string $inheritance = null) : ColumnInterface;
}
