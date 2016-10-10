<?php

namespace Taisiya\PropelBundle\Database;

abstract class AbstractDatabase implements DatabaseInterface
{
    const ID_METHOD_NATIVE = 'native';
    const ID_METHOD_NONE = 'none';
    const PHP_NAMING_METHOD_NOCHANGE = 'nochange';
    const PHP_NAMING_METHOD_UNDERSCORE = 'underscore';
    const PHP_NAMING_METHOD_PHPNAME = 'phpname';
    const PHP_NAMING_METHOD_CLEAN = 'clean';

    /**
     * @var array
     */
    private $tables = [];

    /**
     * The default id method to use for auto-increment columns.
     * @var string
     */
    private $defaultIdMethod = self::ID_METHOD_NATIVE;

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
     * The default namespace that generated model classes will use (PHP 5.3 only).
     * This attribute can be completed or overridden at the table level.
     * @var string|null
     */
    private $namespace = null;

    /**
     * The default base class that all generated Propel objects should extend
     * (in place of propel.om.BaseObject).
     * @var string|null
     */
    private $baseClass = null;

    /**
     * The default naming method to use for tables of this database.
     * Defaults to underscore, which transforms table names into CamelCase phpNames.
     * @var string
     */
    private $defaultPhpNamingMethod = self::PHP_NAMING_METHOD_UNDERSCORE;

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
     * Prefix to all the SQL table names.
     * @var string|null
     */
    private $tablePrefix = null;

    /**
     * AbstractDatabase constructor.
     * @param string $defaultIdMethod Sets the default id method to use for auto-increment columns
     * @throws \InvalidArgumentException
     */
    final public function __construct(string $defaultIdMethod = self::ID_METHOD_NATIVE)
    {
        if (!in_array($defaultIdMethod, [self::ID_METHOD_NATIVE, self::ID_METHOD_NONE])) {
            throw new \InvalidArgumentException('Incorrect value for defaultIdValue');
        }

        $this->defaultIdMethod = $defaultIdMethod;
    }

    /**
     * Gets the default id method.
     * @return string
     */
    public function getDefaultIdMethod(): string
    {
        return $this->defaultIdMethod;
    }

    /**
     * @param TableInterface $table
     * @return DatabaseInterface
     * @throws \InvalidArgumentException
     */
    public function addTable(TableInterface $table): Databaseinterface
    {
        if ($this->hasTable($table->getName())) {
            throw new \InvalidArgumentException('Table '.$table->getName().' already added');
        }

        $this->tables[$table->getName()] = $table;

        return $this;
    }

    /**
     * @param TableInterface $table
     * @return DatabaseInterface
     */
    public function addTableIfNotExists(TableInterface $table): DatabaseInterface
    {
        if (!$this->hasTable($table->getName())) {
            $this->addTable($table);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return TableInterface
     * @throws \InvalidArgumentException
     */
    public function getTable(string $name): TableInterface
    {
        if (!array_key_exists($name, $this->tables)) {
            throw new \InvalidArgumentException('Table '.$name.' not added');
        }

        return $this->tables[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasTable(string $name): bool
    {
        return array_key_exists($name, $this->tables);
    }

    /**
     * @return array
     */
    public function getTables(): array
    {
        return $this->tables;
    }

    /**
     * @return null|string
     */
    public function getPackage(): ?string
    {
        return $this->package;
    }

    /**
     * @param string|null $package
     * @return DatabaseInterface
     */
    public function setPackage(string $package = null): DatabaseInterface
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
     * @param string|null $schema
     * @return DatabaseInterface
     */
    public function setSchema(string $schema = null): DatabaseInterface
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
     * @return DatabaseInterface
     */
    public function setNamespace(string $namespace = null): DatabaseInterface
    {
        $this->namespace = $namespace;

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
     * @return DatabaseInterface
     */
    public function setBaseClass(string $baseClass = null): DatabaseInterface
    {
        $this->baseClass = $baseClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultPhpNamingMethod(): string
    {
        return $this->defaultPhpNamingMethod;
    }

    /**
     * @param string $defaultPhpNamingMethod
     * @throws \InvalidArgumentException
     * @return DatabaseInterface
     */
    public function setDefaultPhpNamingMethod(string $defaultPhpNamingMethod): DatabaseInterface
    {
        $availableMethods = [
            self::PHP_NAMING_METHOD_NOCHANGE,
            self::PHP_NAMING_METHOD_UNDERSCORE,
            self::PHP_NAMING_METHOD_PHPNAME,
            self::PHP_NAMING_METHOD_CLEAN,
        ];

        if (!in_array($defaultPhpNamingMethod, $availableMethods)) {
            throw new \InvalidArgumentException('Invalid naming method.');
        }

        $this->defaultPhpNamingMethod = $defaultPhpNamingMethod;

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
     * @return DatabaseInterface
     */
    public function setHeavyIndexing(bool $heavyIndexing): DatabaseInterface
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
     * @return DatabaseInterface
     */
    public function setIdentifierQuoting(bool $identifierQuoting): DatabaseInterface
    {
        $this->identifierQuoting = $identifierQuoting;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTablePrefix(): ?string
    {
        return $this->tablePrefix;
    }

    /**
     * @param null|string $tablePrefix
     * @return DatabaseInterface
     */
    public function setTablePrefix(string $tablePrefix = null): DatabaseInterface
    {
        $this->tablePrefix = $tablePrefix;

        return $this;
    }
}
