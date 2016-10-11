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
    public function addColumn(Column $column): Table
    {
        if ($this->hasColumn($column->getName())) {
            throw new InvalidArgumentException('Column '.$column->getName().' already added');
        }

        $this->columns[$column->getName()] = $column;

        return $this;
    }

    /**
     * @param Column $column
     * @return Table
     */
    public function addColumnIfNotExists(Column $column): Table
    {
        if (!$this->hasColumn($column->getName())) {
            $this->addColumn($column);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return Column
     * @throws InvalidArgumentException
     */
    public function getColumn(string $name): Column
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
    public function hasColumn(string $name): bool
    {
        return array_key_exists($name, $this->columns);
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return null|string
     */
    public function getPackage(): ?string
    {
        return $this->package;
    }

    /**
     * @param null|string $package
     * @return Table
     */
    public function setPackage(string $package = null): Table
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSchema(): ?string
    {
        return $this->schema;
    }

    /**
     * @param null|string $schema
     * @return Table
     */
    public function setSchema(string $schema = null): Table
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @param null|string $namespace
     * @return Table
     */
    public function setNamespace(string $namespace = null): Table
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSkipSql(): bool
    {
        return $this->skipSql;
    }

    /**
     * @param boolean $skipSql
     * @return Table
     */
    public function setSkipSql(bool $skipSql): Table
    {
        $this->skipSql = $skipSql;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param boolean $abstract
     * @return Table
     */
    public function setAbstract(bool $abstract): Table
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhpNamingMethod(): string
    {
        return $this->phpNamingMethod;
    }

    /**
     * @param string $phpNamingMethod
     * @return Table
     */
    public function setPhpNamingMethod(string $phpNamingMethod): Table
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
    public function getBaseClass(): ?string
    {
        return $this->baseClass;
    }

    /**
     * @param null|string $baseClass
     * @return Table
     */
    public function setBaseClass(string $baseClass = null): Table
    {
        $this->baseClass = $baseClass;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Table
     */
    public function setDescription(string $description = null): Table
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHeavyIndexing(): bool
    {
        return $this->heavyIndexing;
    }

    /**
     * @param boolean $heavyIndexing
     * @return Table
     */
    public function setHeavyIndexing(bool $heavyIndexing): Table
    {
        $this->heavyIndexing = $heavyIndexing;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIdentifierQuoting(): bool
    {
        return $this->identifierQuoting;
    }

    /**
     * @param boolean $identifierQuoting
     * @return Table
     */
    public function setIdentifierQuoting(bool $identifierQuoting): Table
    {
        $this->identifierQuoting = $identifierQuoting;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * @param boolean $readOnly
     * @return Table
     */
    public function setReadOnly(bool $readOnly): Table
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTreeMode(): ?string
    {
        return $this->treeMode;
    }

    /**
     * @param null|string $treeMode
     * @throws InvalidArgumentException
     * @return Table
     */
    public function setTreeMode(string $treeMode = null): Table
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
    public function isReloadOnInsert(): bool
    {
        return $this->reloadOnInsert;
    }

    /**
     * @param boolean $reloadOnInsert
     * @return Table
     */
    public function setReloadOnInsert(bool $reloadOnInsert): Table
    {
        $this->reloadOnInsert = $reloadOnInsert;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isReloadOnUpdate(): bool
    {
        return $this->reloadOnUpdate;
    }

    /**
     * @param boolean $reloadOnUpdate
     * @return Table
     */
    public function setReloadOnUpdate(bool $reloadOnUpdate): Table
    {
        $this->reloadOnUpdate = $reloadOnUpdate;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isAllowPkInsert(): bool
    {
        return $this->allowPkInsert;
    }

    /**
     * @param boolean $allowPkInsert
     * @return Table
     */
    public function setAllowPkInsert(bool $allowPkInsert): Table
    {
        $this->allowPkInsert = $allowPkInsert;

        return $this;
    }
}
