<?php

namespace Taisiya\PropelBundle\Database;

use Propel\Generator\Model\Behavior;
use Taisiya\PropelBundle\Database\Exception\InvalidArgumentException;

abstract class Column implements ColumnInterface
{
    const TYPE_BOOLEAN = 'BOOLEAN';
    const TYPE_TINYINT = 'TINYINT';
    const TYPE_SMALLINT = 'SMALLINT';
    const TYPE_INTEGER = 'INTEGER';
    const TYPE_BIGINT = 'BIGINT';
    const TYPE_DOUBLE = 'DOUBLE';
    const TYPE_FLOAT = 'FLOAT';
    const TYPE_REAL = 'REAL';
    const TYPE_DECIMAL = 'DECIMAL';
    const TYPE_NUMERIC = 'NUMERIC';
    const TYPE_CHAR = 'CHAR';
    const TYPE_VARCHAR = 'VARCHAR';
    const TYPE_LONGVARCHAR = 'LONGVARCHAR';
    const TYPE_DATE = 'DATE';
    const TYPE_TIME = 'TIME';
    const TYPE_TIMESTAMP = 'TIMESTAMP';
    const TYPE_BLOB = 'BLOB';
    const TYPE_CLOB = 'CLOB';
    const TYPE_OBJECT = 'OBJECT';
    const TYPE_ARRAY = 'ARRAY';
    const TYPE_ENUM = 'ENUM';
    const TYPE_SET = 'SET';
    const TYPE_GEOMETRY = 'GEOMETRY';
    const TYPE_BU_DATE = 'BU_DATE';
    const TYPE_BU_TIMESTAMP = 'BU_TIMESTAMP';
    const TYPE_BOOLEAN_EMU = 'BOOLEAN_EMU';
    const TYPE_BINARY = 'BINARY';
    const TYPE_VARBINARY = 'VARBINARY';
    const TYPE_LONGVARBINARY = 'LONGVARBINARY';

    const SQL_TYPE_BOOLEAN = 'boolean';
    const SQL_TYPE_INT = 'int';
    const SQL_TYPE_INTEGER = 'integer';
    const SQL_TYPE_DOUBLE = 'double';
    const SQL_TYPE_FLOAT = 'float';
    const SQL_TYPE_STRING = 'string';

    /**
     * @var array
     */
    private $foreignKeys = [];

    /**
     * Object model class name. By default,
     * Propel uses a CamelCase version of the table name as phpName.
     * @var string|null
     */
    private $phpName = null;

    /**
     * The table map name.
     * @var string|null
     */
    private $tableMapName = null;

    /**
     * Is primary key or not.
     * @var bool
     */
    private $primaryKey = false;

    /**
     * Is required or not.
     * @var bool
     */
    private $required = false;

    /**
     * The database-agnostic column type.
     * Propel maps native SQL types to these types depending on the RDBMS.
     * Using Propel types guarantees that a column definition is portable.
     * @var string|null
     */
    private $type = null;

    /**
     * The PHP type.
     * @var string|null
     */
    private $phpType = null;

    /**
     * The SQL type to be used in CREATE and ALTER statements
     * (overriding the mapping between Propel types and RMDBS type).
     * @var string|null
     */
    private $sqlType = null;

    /**
     * Numeric length of column.
     * @var integer|null
     */
    private $size = null;

    /**
     * Digits after decimal place.
     * @var integer|null
     */
    private $scale = null;

    /**
     * The default value that the object will have for this column in the PHP instance
     * after creating a “new Object”. This value is always interpreted as a string.
     * @var string|null
     */
    private $defaultvalue = null;

    /**
     * The default value for this column as expressed in SQL. This value is used solely
     * for the “sql” target which builds your database from the schema.xml file.
     * The defaultExpr is the SQL expression used as the “default” for the column.
     * @var string|null
     */
    private $defaultExpr = null;

    /**
     * The list of enumerated values accepted on an ENUM column.
     * The list contains 255 values at most, separated by commas.
     * @var string|null
     */
    private $valueSet = null;

    /**
     * @var bool
     */
    private $autoIncrement = false;

    /**
     * A lazy-loaded column is not fetched from the database by model queries.
     * Only the generated getter method for such a column issues a query to the database.
     * Useful for large column types (such as CLOB and BLOB).
     * @var bool
     */
    private $lazyLoad = false;

    /**
     * Column description.
     * @var string|null
     */
    private $description = null;

    /**
     * A column defined as primary string serves as default value for a __toString() method
     * in the generated Propel object.
     * @var bool
     */
    private $primaryString = false;

    /**
     * @var string
     */
    private $phpNamingMethod = Database::PHP_NAMING_METHOD_UNDERSCORE;

    /**
     * @var string|bool
     */
    private $inheritance = false;

    /**
     * @param ForeignKey $foreignKey
     * @throws InvalidArgumentException
     * @return Column
     */
    public function addForeignKey(ForeignKey $foreignKey): Column
    {
        if (array_key_exists($foreignKey->getName(), $this->foreignKeys)) {
            throw new InvalidArgumentException('Foreign key '.$foreignKey->getName().' already added.');
        }

        $this->foreignKeys[$foreignKey->getName()] = $foreignKey;

        return $this;
    }

    /**
     * @return array
     */
    public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }

    /**
     * @param string $name
     * @throws InvalidArgumentException
     * @return ForeignKey
     */
    public function getForeignKey(string $name): ForeignKey
    {
        if (! $this->hasForeignKey($name)) {
            throw new InvalidArgumentException('Foreign key '.$name.' not added.');
        }

        return $this->foreignKeys[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasForeignKey(string $name): bool
    {
        return array_key_exists($name, $this->foreignKeys);
    }

    /**
     * @return null|string
     */
    public function getPhpName(): ?string
    {
        return $this->phpName;
    }

    /**
     * @param null|string $phpName
     * @return ColumnInterface
     */
    public function setPhpName(string $phpName = null): ColumnInterface
    {
        $this->phpName = $phpName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTableMapName(): ?string
    {
        return $this->tableMapName;
    }

    /**
     * @param null|string $tableMapName
     * @return ColumnInterface
     */
    public function setTableMapName(string $tableMapName = null): ColumnInterface
    {
        $this->tableMapName = $tableMapName;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrimaryKey(): bool
    {
        return $this->primaryKey;
    }

    /**
     * @param boolean $primaryKey
     * @return ColumnInterface
     */
    public function setPrimaryKey(bool $primaryKey): ColumnInterface
    {
        $this->primaryKey = $primaryKey;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     * @return ColumnInterface
     */
    public function setRequired(bool $required): ColumnInterface
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     * @throws \InvalidArgumentException
     * @return ColumnInterface
     */
    public function setType(string $type = null): ColumnInterface
    {
        if ($type) {
            $available = [
                self::TYPE_ARRAY,
                self::TYPE_BIGINT,
                self::TYPE_BINARY,
                self::TYPE_BLOB,
                self::TYPE_BOOLEAN,
                self::TYPE_BOOLEAN_EMU,
                self::TYPE_BU_DATE,
                self::TYPE_BU_TIMESTAMP,
                self::TYPE_CHAR,
                self::TYPE_CLOB,
                self::TYPE_BINARY,
                self::TYPE_BLOB,
                self::TYPE_DATE,
                self::TYPE_DECIMAL,
                self::TYPE_DOUBLE,
                self::TYPE_ENUM,
                self::TYPE_FLOAT,
                self::TYPE_GEOMETRY,
                self::TYPE_INTEGER,
                self::TYPE_LONGVARBINARY,
                self::TYPE_NUMERIC,
                self::TYPE_OBJECT,
                self::TYPE_REAL,
                self::TYPE_SET,
                self::TYPE_SMALLINT,
                self::TYPE_TIME,
                self::TYPE_TIMESTAMP,
                self::TYPE_TINYINT,
                self::TYPE_VARCHAR,
                self::TYPE_VARBINARY,
            ];

            if (!in_array($type, $available)) {
                throw new \InvalidArgumentException('Invalid Propel type.');
            }
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhpType(): ?string
    {
        return $this->phpType;
    }

    /**
     * @param null|string $phpType
     * @return ColumnInterface
     */
    public function setPhpType(string $phpType = null): ColumnInterface
    {
        $this->phpType = $phpType;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSqlType(): ?string
    {
        return $this->sqlType;
    }

    /**
     * @param null|string $sqlType
     * @throws \InvalidArgumentException
     * @return ColumnInterface
     */
    public function setSqlType(string $sqlType = null): ColumnInterface
    {
        if ($sqlType) {
            $available = [
                self::SQL_TYPE_BOOLEAN,
                self::SQL_TYPE_DOUBLE,
                self::SQL_TYPE_FLOAT,
                self::SQL_TYPE_INT,
                self::SQL_TYPE_INTEGER,
                self::SQL_TYPE_STRING,
            ];

            if (!in_array($sqlType, $available)) {
                if (!class_exists($sqlType)) {
                    throw new \InvalidArgumentException('Invalid SQL type: '.$sqlType);
                } else {
                    $reflection = new \ReflectionClass($sqlType);
                    if (!$reflection->isSubclassOf(Behavior::class)) {
                        throw new \InvalidArgumentException('SQL type '.$sqlType.' must be instance of '.Behavior::class);
                    }
                }
            }
        }

        $this->sqlType = $sqlType;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return ColumnInterface
     */
    public function setSize(int $size = null): ColumnInterface
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getScale(): ?int
    {
        return $this->scale;
    }

    /**
     * @param int|null $scale
     * @return ColumnInterface
     */
    public function setScale(int $scale = null): ColumnInterface
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDefaultvalue(): ?string
    {
        return $this->defaultvalue;
    }

    /**
     * @param null|string $defaultvalue
     * @return ColumnInterface
     */
    public function setDefaultvalue(string $defaultvalue = null): ColumnInterface
    {
        $this->defaultvalue = $defaultvalue;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDefaultExpr(): ?string
    {
        return $this->defaultExpr;
    }

    /**
     * @param null|string $defaultExpr
     * @return ColumnInterface
     */
    public function setDefaultExpr(string $defaultExpr = null): ColumnInterface
    {
        $this->defaultExpr = $defaultExpr;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getValueSet(): ?string
    {
        return $this->valueSet;
    }

    /**
     * @param null|string $valueSet
     * @return ColumnInterface
     */
    public function setValueSet(string $valueSet = null): ColumnInterface
    {
        $this->valueSet = $valueSet;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @param boolean $autoIncrement
     * @return ColumnInterface
     */
    public function setAutoIncrement(bool $autoIncrement): ColumnInterface
    {
        $this->autoIncrement = $autoIncrement;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isLazyLoad(): bool
    {
        return $this->lazyLoad;
    }

    /**
     * @param boolean $lazyLoad
     * @return ColumnInterface
     */
    public function setLazyLoad(bool $lazyLoad): ColumnInterface
    {
        $this->lazyLoad = $lazyLoad;
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
     * @return ColumnInterface
     */
    public function setDescription(string $description = null): ColumnInterface
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrimaryString(): bool
    {
        return $this->primaryString;
    }

    /**
     * @param boolean $primaryString
     * @return ColumnInterface
     */
    public function setPrimaryString(bool $primaryString): ColumnInterface
    {
        $this->primaryString = $primaryString;
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
     * @return ColumnInterface
     */
    public function setPhpNamingMethod(string $phpNamingMethod): ColumnInterface
    {
        $this->phpNamingMethod = $phpNamingMethod;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getInheritance(): ?string
    {
        return $this->inheritance;
    }

    /**
     * @param bool|string $inheritance
     * @return ColumnInterface
     */
    public function setInheritance(string $inheritance = null): ColumnInterface
    {
        $this->inheritance = $inheritance;
        return $this;
    }
}
