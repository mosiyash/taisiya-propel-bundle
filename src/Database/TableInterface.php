<?php

namespace Taisiya\PropelBundle\Database;

interface TableInterface
{
    public function getName(): string;

    public function getIdMethod(): string;

    public function setIdMethod(string $idMethod): self;

    public function getPhpName(): ?string;

    public function addColumn(ColumnInterface $column): self;

    public function addColumnIfNotExists(ColumnInterface $column): self;

    public function getColumn(string $name): ColumnInterface;

    public function hasColumn(string $name): bool;

    public function getColumns(): array;

    public function getPackage(): ?string;

    public function setPackage(string $package = null): self;

    public function getSchema(): ?string;

    public function setSchema(string $schema = null): TableInterface;

    public function getNamespace(): ?string;

    public function setNamespace(string $namespace = null): TableInterface;

    public function isSkipSql(): bool;

    public function setSkipSql(bool $skipSql): TableInterface;

    public function isAbstract(): bool;

    public function setAbstract(bool $abstract): TableInterface;

    public function getPhpNamingMethod(): string;

    public function setPhpNamingMethod(string $phpNamingMethod): TableInterface;

    public function getBaseClass(): ?string;

    public function setBaseClass(string $baseClass = null): TableInterface;

    public function getDescription(): ?string;

    public function setDescription(string $description = null): TableInterface;

    public function isHeavyIndexing(): bool;

    public function setHeavyIndexing(bool $heavyIndexing): TableInterface;

    public function isIdentifierQuoting(): bool;

    public function setIdentifierQuoting(bool $identifierQuoting): TableInterface;

    public function isReadOnly(): bool;

    public function setReadOnly(bool $readOnly): TableInterface;

    public function getTreeMode(): ?string;

    public function setTreeMode(string $treeMode = null): TableInterface;

    public function isReloadOnInsert(): bool;

    public function setReloadOnInsert(bool $reloadOnInsert): TableInterface;

    public function isReloadOnUpdate(): bool;

    public function setReloadOnUpdate(bool $reloadOnUpdate): TableInterface;

    public function isAllowPkInsert(): bool;

    public function setAllowPkInsert(bool $allowPkInsert): TableInterface;
}
