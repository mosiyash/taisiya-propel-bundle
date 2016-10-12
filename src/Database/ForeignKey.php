<?php

namespace Taisiya\PropelBundle\Database;

abstract class ForeignKey implements ForeignKeyInterface
{
    const ON_UPDATE_DELETE_CASCADE = 'cascade';
    const ON_UPDATE_DELETE_SETNULL = 'setnull';
    const ON_UPDATE_DELETE_RESTRICT = 'restrict';
    const ON_UPDATE_DELETE_NONE = 'none';

    /**
     * @var Table
     */
    private $foreignTable;

    /**
     * @var ForeignKeyReference
     */
    private $foreignKeyReference;

    /**
     * The other table SQL schema.
     * @var string|null
     */
    private $foreignSchema = null;

    /**
     * Name for this foreign key.
     * @var string|null
     */
    private $name = null;

    /**
     * Name for the foreign object in methods generated in this class.
     * @var string|null
     */
    private $phpName = null;

    /**
     * Name for this object in methods generated in the foreign class.
     * @var string|null
     */
    private $refPhpName = null;

    /**
     * @var string|null
     */
    private $onDelete = null;

    /**
     * @var string|null
     */
    private $onUpdate = null;

    /**
     * Instructs Propel not to generate DDL SQL for the specified foreign key.
     * This can be used to support relationships in the model without an actual foreign key.
     * @var boolean|null
     */
    private $skipSql = null;

    /**
     * This affects the default join type used in the generated joinXXX() methods
     * in the model query class. Propel uses an INNER JOIN for foreign keys attached
     * to a required column, and a LEFT JOIN for foreign keys attached
     * to a non-required column, but you can override this in the foreign key element.
     * @var string|null
     */
    private $defaultJoin = null;

    /**
     * ForeignKey constructor.
     * @param Table $foreignTable
     * @param ForeignKeyReference $foreignKeyReference
     */
    final public function __construct(Table $foreignTable, ForeignKeyReference $foreignKeyReference)
    {
        $this->foreignTable = $foreignTable;
        $this->foreignKeyReference = $foreignKeyReference;
    }

    /**
     * @return Table
     */
    final public function getForeignTable(): Table
    {
        return $this->foreignTable;
    }

    /**
     * @return ForeignKeyReference
     */
    final public function getForeignKeyReference(): ForeignKeyReference
    {
        return $this->foreignKeyReference;
    }

    /**
     * @return null|string
     */
    final public function getForeignSchema(): ?string
    {
        return $this->foreignSchema;
    }

    /**
     * @param null|string $foreignSchema
     * @return ForeignKey
     */
    final public function setForeignSchema($foreignSchema)
    {
        $this->foreignSchema = $foreignSchema;
        return $this;
    }

    /**
     * @param null|string $name
     * @return ForeignKey
     */
    final public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return null|string
     */
    final public function getPhpName()
    {
        return $this->phpName;
    }

    /**
     * @param null|string $phpName
     * @return ForeignKey
     */
    final public function setPhpName($phpName)
    {
        $this->phpName = $phpName;
        return $this;
    }

    /**
     * @return null|string
     */
    final public function getRefPhpName()
    {
        return $this->refPhpName;
    }

    /**
     * @param null|string $refPhpName
     * @return ForeignKey
     */
    final public function setRefPhpName($refPhpName)
    {
        $this->refPhpName = $refPhpName;
        return $this;
    }

    /**
     * @return null|string
     */
    final public function getOnDelete()
    {
        return $this->onDelete;
    }

    /**
     * @param null|string $onDelete
     * @return ForeignKey
     */
    final public function setOnDelete($onDelete)
    {
        $this->onDelete = $onDelete;
        return $this;
    }

    /**
     * @return null|string
     */
    final public function getOnUpdate()
    {
        return $this->onUpdate;
    }

    /**
     * @param null|string $onUpdate
     * @return ForeignKey
     */
    final public function setOnUpdate($onUpdate)
    {
        $this->onUpdate = $onUpdate;
        return $this;
    }

    /**
     * @return bool|null
     */
    final public function getSkipSql()
    {
        return $this->skipSql;
    }

    /**
     * @param bool|null $skipSql
     * @return ForeignKey
     */
    final public function setSkipSql($skipSql)
    {
        $this->skipSql = $skipSql;
        return $this;
    }

    /**
     * @return null|string
     */
    final public function getDefaultJoin()
    {
        return $this->defaultJoin;
    }

    /**
     * @param null|string $defaultJoin
     * @return ForeignKey
     */
    final public function setDefaultJoin($defaultJoin)
    {
        $this->defaultJoin = $defaultJoin;
        return $this;
    }
}
