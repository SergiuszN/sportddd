<?php

namespace Ddd\Framework\Database;

use Ddd\Framework\Config\Config;

interface Database
{
    public static function getConnection(Config $databaseConfig): self;
    public function getConnectionName(): string;
    public function query(string $query): void;
    public function prepare(string $query): void;
    public function execute(array $params = []): void;
    public function fetchRowAssoc(): ?array;
    public function fetchAllAssoc(): ?array;
    public function fetchSingleScalarValue(): ?int;
    public function lastInsertedId(): ?string;
}