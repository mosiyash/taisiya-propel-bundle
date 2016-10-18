<?php

namespace Taisiya\PropelBundle\Database;

use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;

abstract class Database implements DatabaseInterface
{
    const ID_METHOD_NATIVE             = 'native';
    const ID_METHOD_NONE               = 'none';
    const PHP_NAMING_METHOD_NOCHANGE   = 'nochange';
    const PHP_NAMING_METHOD_UNDERSCORE = 'underscore';
    const PHP_NAMING_METHOD_PHPNAME    = 'phpname';
    const PHP_NAMING_METHOD_CLEAN      = 'clean';

    /**
     * @var array
     */
    private $tables = [];

    /**
     * The default id method to use for auto-increment columns.
     *
     * @var string
     */
    private $defaultIdMethod = self::ID_METHOD_NATIVE;

    /**
     * The “package” for the generated classes.
     * Classes are created in subdirectories according to the package value.
     *
     * @var string|null
     */
    private $package = null;

    /**
     * The default SQL schema containing the tables.
     * Ignored on RDBMS not supporting database schemas.
     *
     * @var string|null
     */
    private $schema = null;

    /**
     * The default namespace that generated model classes will use (PHP 5.3 only).
     * This attribute can be completed or overridden at the table level.
     *
     * @var string|null
     */
    private $namespace = null;

    /**
     * The default base class that all generated Propel objects should extend
     * (in place of propel.om.BaseObject).
     *
     * @var string|null
     */
    private $baseClass = null;

    /**
     * The default naming method to use for tables of this database.
     * Defaults to underscore, which transforms table names into CamelCase phpNames.
     *
     * @var string
     */
    private $defaultPhpNamingMethod = self::PHP_NAMING_METHOD_UNDERSCORE;

    /**
     * Adds indexes for each component of the primary key (when using composite primary keys).
     *
     * @var bool
     */
    private $heavyIndexing = false;

    /**
     * Auotes all identifiers (table name, column names) in DDL and SQL queries.
     * This is necessary if you use reserved words as table or column name.
     *
     * @var bool
     */
    private $identifierQuoting = false;

    /**
     * Prefix to all the SQL table names.
     *
     * @var string|null
     */
    private $tablePrefix = null;

    /**
     * Database constructor.
     *
     * @param string $defaultIdMethod Sets the default id method to use for auto-increment columns
     *
     * @throws InvalidArgumentException
     */
    final public function __construct(string $defaultIdMethod = self::ID_METHOD_NATIVE)
    {
        if (!in_array($defaultIdMethod, [self::ID_METHOD_NATIVE, self::ID_METHOD_NONE])) {
            throw new InvalidArgumentException('Incorrect value for defaultIdValue');
        }

        $this->defaultIdMethod = $defaultIdMethod;
    }

    /**
     * Gets the default id method.
     *
     * @return string
     */
    final public function getDefaultIdMethod(): string
    {
        return $this->defaultIdMethod;
    }

    /**
     * @param Table $table
     *
     * @throws InvalidArgumentException
     *
     * @return Database
     */
    final public function createTable(Table $table): Database
    {
        if ($this->hasTable($table::getName())) {
            throw new InvalidArgumentException('Table '.$table::getName().' already added');
        }

        $this->tables[$table::getName()] = $table;

        return $this;
    }

    /**
     * @param Table $table
     *
     * @return Database
     */
    final public function createTableIfNotExists(Table $table): Database
    {
        if (!$this->hasTable($table::getName())) {
            $this->createTable($table);
        }

        return $this;
    }

    /**
     * @param Table $table
     *
     * @throws InvalidArgumentException
     *
     * @return Database
     */
    final public function removeTable(Table $table): Database
    {
        if (!$this->hasTable($table::getName())) {
            throw new InvalidArgumentException('Table '.$table::getName().' not exists');
        }

        unset($this->tables[$table::getName()]);

        return $this;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return Table
     */
    final public function getTable(string $name): Table
    {
        if (!array_key_exists($name, $this->tables)) {
            throw new InvalidArgumentException('Table '.$name.' not added');
        }

        return $this->tables[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    final public function hasTable(string $name): bool
    {
        return array_key_exists($name, $this->tables);
    }

    /**
     * @return array
     */
    final public function getTables(): array
    {
        return $this->tables;
    }

    /**
     * @return null|string
     */
    final public function getPackage(): ? string
    {
        return $this->package;
    }

    /**
     * @param string|null $package
     *
     * @return Database
     */
    final public function setPackage(string $package = null) : Database
    {
        $this->package = $package;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getSchema(): ? string
    {
        return $this->schema;
    }

    /**
     * @param string|null $schema
     *
     * @return Database
     */
    final public function setSchema(string $schema = null) : Database
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getNamespace(): ? string
    {
        return $this->namespace;
    }

    /**
     * @param null|string $namespace
     *
     * @return Database
     */
    final public function setNamespace(string $namespace = null) : Database
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getBaseClass(): ? string
    {
        return $this->baseClass;
    }

    /**
     * @param null|string $baseClass
     *
     * @return Database
     */
    final public function setBaseClass(string $baseClass = null) : Database
    {
        $this->baseClass = $baseClass;

        return $this;
    }

    /**
     * @return string
     */
    final public function getDefaultPhpNamingMethod(): string
    {
        return $this->defaultPhpNamingMethod;
    }

    /**
     * @param string $defaultPhpNamingMethod
     *
     * @throws InvalidArgumentException
     *
     * @return Database
     */
    final public function setDefaultPhpNamingMethod(string $defaultPhpNamingMethod): Database
    {
        $availableMethods = [
            self::PHP_NAMING_METHOD_NOCHANGE,
            self::PHP_NAMING_METHOD_UNDERSCORE,
            self::PHP_NAMING_METHOD_PHPNAME,
            self::PHP_NAMING_METHOD_CLEAN,
        ];

        if (!in_array($defaultPhpNamingMethod, $availableMethods)) {
            throw new InvalidArgumentException('Invalid naming method.');
        }

        $this->defaultPhpNamingMethod = $defaultPhpNamingMethod;

        return $this;
    }

    /**
     * @return bool
     */
    final public function isHeavyIndexing(): bool
    {
        return $this->heavyIndexing;
    }

    /**
     * @param bool $heavyIndexing
     *
     * @return Database
     */
    final public function setHeavyIndexing(bool $heavyIndexing): Database
    {
        $this->heavyIndexing = $heavyIndexing;

        return $this;
    }

    /**
     * @return bool
     */
    final public function isIdentifierQuoting(): bool
    {
        return $this->identifierQuoting;
    }

    /**
     * @param bool $identifierQuoting
     *
     * @return Database
     */
    final public function setIdentifierQuoting(bool $identifierQuoting): Database
    {
        $this->identifierQuoting = $identifierQuoting;

        return $this;
    }

    /**
     * @return null|string
     */
    final public function getTablePrefix(): ? string
    {
        return $this->tablePrefix;
    }

    /**
     * @param null|string $tablePrefix
     *
     * @return Database
     */
    final public function setTablePrefix(string $tablePrefix = null) : Database
    {
        $this->tablePrefix = $tablePrefix;

        return $this;
    }

    /**
     * @param \DOMDocument $dom
     */
    final public function appendToXmlDocument(\DOMDocument $dom): void
    {
        $database = $dom->createElement('database');
        $database->setAttribute('name', $this::getName());
        $database->setAttribute('defaultIdMethod', $this->getDefaultIdMethod());

        $additionalProperties = [
            'package',
            'schema',
            'namespace',
            'baseClass',
            'defaultPhpNamingMethod',
            'heavyIndexing',
            'identifierQuoting',
            'tablePrefix',
        ];

        foreach ($additionalProperties as $propertyName) {
            $method = method_exists($this, 'get'.ucfirst($propertyName))
                ? 'get'.ucfirst($propertyName)
                : 'is'.ucfirst($propertyName);

            $propertyValue = $this->{$method}();
            if ($propertyValue != '') {
                if (is_bool($propertyValue)) {
                    $propertyValue = $propertyValue ? 'true' : false;
                }
                $database->setAttribute($propertyName, $propertyValue);
            }
        }

        /** @var Table $table */
        foreach ($this->getTables() as $table) {
            $table->appendToXmlDocument($dom, $database);
        }

        $dom->appendChild($database);
    }
}
