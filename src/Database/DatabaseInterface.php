<?php

namespace Taisiya\PropelBundle\Database;

interface DatabaseInterface
{
    public function __construct(string $defaultIdMethod = AbstractDatabase::ID_METHOD_NATIVE);

    public function getName(): string;

    public function getDefaultIdMethod(): string;

    public function addTable(TableInterface $table): self;

    public function addTableIfNotExists(TableInterface $table): self;

    public function getTable(string $name): TableInterface;

    public function hasTable(string $name): bool;

    public function getTables(): array;

    public function getPackage(): ?string;

    public function setPackage(string $package = null): DatabaseInterface;

    public function getSchema(): ?string;

    public function setSchema(string $schema = null): DatabaseInterface;

    public function getNamespace(): ?string;

    public function setNamespace(string $namespace = null): DatabaseInterface;

    public function getBaseClass(): ?string;

    public function setBaseClass(string $baseClass = null): DatabaseInterface;

    public function getDefaultPhpNamingMethod(): string;

    public function setDefaultPhpNamingMethod(string $defaultPhpNamingMethod): DatabaseInterface;

    public function isHeavyIndexing(): bool;

    public function setHeavyIndexing(bool $heavyIndexing): DatabaseInterface;

    public function isIdentifierQuoting(): bool;

    public function setIdentifierQuoting(bool $identifierQuoting): DatabaseInterface;

    public function getTablePrefix(): ?string;

    public function setTablePrefix(string $tablePrefix = null): DatabaseInterface;
}
