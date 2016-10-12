<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;

abstract class Table implements TableInterface
{
    const TREE_MODE_NESTED_SET = 'nested_set';
    const TREE_MODE_MATERIALIZED_PATH = 'materialized_path';

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var array
     */
    private $foreignKeys = [];

    /**
     * The id method to use for auto-increment columns.
     * @var string
     */
    private $idMethod = Database::ID_METHOD_NATIVE;

    /**
     * Object model class name. By default,
     * Propel uses a CamelCase version of the table name as phpName.
     * @var string|null
     */
    private $phpName = null;

    /**
     * The “package” for the generated classes.
     * Classes are created in subdirectories according to the package value.
     * @var string|null
     */
    private $package = null;

    /**
     * The default SQL schema containing the tables.
     * Ignored on RDBMS not supporting database schemas.
     * @var string|null
     */
    private $schema = null;

    /**
     * The namespace that the generated model classes will use (PHP 5.3 only).
     * If the table namespace starts with a \\, it overrides the namespace
     * defined in the <database> tag; otherwise, the actual table namespace
     * is the concatenation of the database namespace and the table namespace.
     * @var string|null
     */
    private $namespace = null;

    /**
     * Instructs Propel not to generate DDL SQL for the specified table.
     * This can be used together with readOnly for supporting VIEWS in Propel.
     * @var bool
     */
    private $skipSql = false;

    /**
     * Whether the generated stub class will be abstract (e.g. if you’re using inheritance).
     * @var bool
     */
    private $abstract = false;

    /**
     * The default naming method to use for tables of this database.
     * Defaults to underscore, which transforms table names into CamelCase phpNames.
     * @var string
     */
    private $phpNamingMethod = Database::PHP_NAMING_METHOD_UNDERSCORE;

    /**
     * Allows you to specify a class that the generated Propel objects should extend
     * (in place of propel.om.BaseObject).
     * @var string|null
     */
    private $baseClass = null;

    /**
     * A text description of the table.
     * @var string|null
     */
    private $description = null;

    /**
     * Adds indexes for each component of the primary key (when using composite primary keys).
     * @var bool
     */
    private $heavyIndexing = false;

    /**
     * Auotes all identifiers (table name, column names) in DDL and SQL queries.
     * This is necessary if you use reserved words as table or column name.
     * @var bool
     */
    private $identifierQuoting = false;

    /**
     * Suppresses the mutator/setter methods, save() and delete() methods.
     * @var bool
     */
    private $readOnly = false;

    /**
     * Is used to indicate that this table is part of a node tree.
     * Currently the only supported values are NestedSet (see the NestedSet behavior section)
     * and MaterializedPath (deprecated).
     * @var string|null
     */
    private $treeMode = null;

    /**
     * Is used to indicate that the object should be reloaded from the database
     * when an INSERT is performed. This is useful if you have triggers
     * (or other server-side functionality like column default expressions)
     * that alters the database row on INSERT.
     * @var bool
     */
    private $reloadOnInsert = true;

    /**
     * Is used to indicate that the object should be reloaded from the database
     * when an UPDATE is performed. This is useful if you have triggers
     * (or other server-side functionality like column default expressions)
     * that alters the database row on UPDATE.
     * @var bool
     */
    private $reloadOnUpdate = true;

    /**
     * Can be used if you want to define the primary key of a new object being inserted.
     * By default if idMethod is “native”, Propel would throw an exception.
     * However, in some cases this feature is useful, for example if you do some replication
     * of data in an master-master environment. It defaults to false.
     * @var bool
     */
    private $allowPkInsert = false;

    /**
     * @return string
     */
    final public function getIdMethod(): string
    {
        return $this->idMethod;
    }

    /**
     * @param string $idMethod
     * @return Table
     * @throws InvalidArgumentException
     */
    final public function setIdMethod(string $idMethod): Table
    {
        $available = [
            Database::ID_METHOD_NATIVE,
            Database::ID_METHOD_NONE,
        ];

        if (!in_array($idMethod, $available)) {
            throw new InvalidArgumentException('Invalid idMethod value');
        }

        $this->idMethod = $idMethod;

        return $this;
    }

    /**
     * @return string|null
     */
    final public function getPhpName(): ?string
    {
        return $this->phpName;
    }

    /**
     * @param string|null $phpName
     * @return Database
     */
    final public function setPhpName(string $phpName = null)
    {
        $this->phpName = $phpName;

        return $this;
    }

    /**
     * @param Column $column
     * @return Table
     * @throws InvalidArgumentException
     */
    final public function createColumn(Column $column): Table
    {
        if ($this->hasColumn($column::getName())) {
            throw new InvalidArgumentException('Column '.$column::getName().' already added');
        }

        $this->columns[$column::getName()] = $column;

        return $this;
    }

    /**
     * @param Column $column
     * @return Table
     */
    final public function createColumnIfNotExists(Column $column): Table
    {
        if (!$this->hasColumn($column::getName())) {
            $this->createColumn($column);
        }

        return $this;
    }

    /**
     * @param Column $column
     * @return Table
     * @throws InvalidArgumentException
     */
    final public function removeColumn(Column $column): Table
    {
        if (!$this->hasColumn($column::getName())) {
            throw new InvalidArgumentException('Column '.$column::getName().' not exists');
        }

        unset($this->columns[$column::getName()]);

        return $this;
    }

    /**
     * @param string $name
     * @return Column
     * @throws InvalidArgumentException
     */
    final public function getColumn(string $name): Column
    {
        if (!array_key_exists($name, $this->columns)) {
            throw new InvalidArgumentException('Column '.$name.' not added');
        }

        return $this->columns[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    final public function hasColumn(string $name): bool
    {
        return array_key_exists($name, $this->columns);
    }

    /**
     * @return array
     */
    final public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return null|string
     */
    final public function getPackage(): ?string
    {
        return $this->package;
    }

    /**
     * @param null|string $package
     * @return Table
     */
    final public function setPackage(string $package = null): Table
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getSchema(): ?string
    {
        return $this->schema;
    }

    /**
     * @param null|string $schema
     * @return Table
     */
    final public function setSchema(string $schema = null): Table
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @param null|string $namespace
     * @return Table
     */
    final public function setNamespace(string $namespace = null): Table
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isSkipSql(): bool
    {
        return $this->skipSql;
    }

    /**
     * @param boolean $skipSql
     * @return Table
     */
    final public function setSkipSql(bool $skipSql): Table
    {
        $this->skipSql = $skipSql;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param boolean $abstract
     * @return Table
     */
    final public function setAbstract(bool $abstract): Table
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * @return string
     */
    final public function getPhpNamingMethod(): string
    {
        return $this->phpNamingMethod;
    }

    /**
     * @param string $phpNamingMethod
     * @return Table
     */
    final public function setPhpNamingMethod(string $phpNamingMethod): Table
    {
        $availableMethods = [
            Database::PHP_NAMING_METHOD_NOCHANGE,
            Database::PHP_NAMING_METHOD_UNDERSCORE,
            Database::PHP_NAMING_METHOD_PHPNAME,
            Database::PHP_NAMING_METHOD_CLEAN,
        ];

        if (!in_array($phpNamingMethod, $availableMethods)) {
            throw new InvalidArgumentException('Invalid naming method.');
        }

        $this->phpNamingMethod = $phpNamingMethod;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getBaseClass(): ?string
    {
        return $this->baseClass;
    }

    /**
     * @param null|string $baseClass
     * @return Table
     */
    final public function setBaseClass(string $baseClass = null): Table
    {
        $this->baseClass = $baseClass;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Table
     */
    final public function setDescription(string $description = null): Table
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isHeavyIndexing(): bool
    {
        return $this->heavyIndexing;
    }

    /**
     * @param boolean $heavyIndexing
     * @return Table
     */
    final public function setHeavyIndexing(bool $heavyIndexing): Table
    {
        $this->heavyIndexing = $heavyIndexing;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isIdentifierQuoting(): bool
    {
        return $this->identifierQuoting;
    }

    /**
     * @param boolean $identifierQuoting
     * @return Table
     */
    final public function setIdentifierQuoting(bool $identifierQuoting): Table
    {
        $this->identifierQuoting = $identifierQuoting;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param boolean $readOnly
     * @return Table
     */
    final public function setReadOnly(bool $readOnly): Table
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getTreeMode(): ?string
    {
        return $this->treeMode;
    }

    /**
     * @param null|string $treeMode
     * @throws InvalidArgumentException
     * @return Table
     */
    final public function setTreeMode(string $treeMode = null): Table
    {
        if ($treeMode !== null) {
            $available = [
                self::TREE_MODE_NESTED_SET,
                self::TREE_MODE_MATERIALIZED_PATH,
            ];

            if (!in_array($treeMode, $available)) {
                throw new InvalidArgumentException('Invalid tree mode.');
            }
        }

        $this->treeMode = $treeMode;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isReloadOnInsert(): bool
    {
        return $this->reloadOnInsert;
    }

    /**
     * @param boolean $reloadOnInsert
     * @return Table
     */
    final public function setReloadOnInsert(bool $reloadOnInsert): Table
    {
        $this->reloadOnInsert = $reloadOnInsert;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isReloadOnUpdate(): bool
    {
        return $this->reloadOnUpdate;
    }

    /**
     * @param boolean $reloadOnUpdate
     * @return Table
     */
    final public function setReloadOnUpdate(bool $reloadOnUpdate): Table
    {
        $this->reloadOnUpdate = $reloadOnUpdate;

        return $this;
    }

    /**
     * @return boolean
     */
    final public function isAllowPkInsert(): bool
    {
        return $this->allowPkInsert;
    }

    /**
     * @param boolean $allowPkInsert
     * @return Table
     */
    final public function setAllowPkInsert(bool $allowPkInsert): Table
    {
        $this->allowPkInsert = $allowPkInsert;

        return $this;
    }

    /**
     * @return array
     */
    final public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }

    /**
     * @param string $name
     * @return ForeignKey
     */
    final public function getForeignKey(string $name): ForeignKey
    {
        return $this->foreignKeys[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    final public function hasForeignKey(string $name): bool
    {
        return array_key_exists($name, $this->foreignKeys);
    }

    /**
     * @param ForeignKey $foreignKey
     * @return Table
     */
    final public function addForeignKey(ForeignKey $foreignKey): Table
    {
        if ($this->hasForeignKey($foreignKey::getName())) {
            throw new InvalidArgumentException('Foreign key '.$foreignKey::getName().' already exists in the table '.$this::getName());
        }

        $this->foreignKeys[$foreignKey::getName()] = $foreignKey;

        return $this;
    }

    /**
     * @param ForeignKey $foreignKey
     * @return Table
     */
    final public function removeForeignKey(ForeignKey $foreignKey): Table
    {
        if (!$this->hasForeignKey($foreignKey::getName())) {
            throw new InvalidArgumentException('Foreign key '.$foreignKey::getName().' not exists in the table '.$this::getName());
        }

        unset($this->foreignKeys[$foreignKey::getName()]);

        return $this;
    }
}
