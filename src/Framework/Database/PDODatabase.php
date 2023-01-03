<?php

namespace Ddd\Framework\Database;

use Ddd\Framework\Config\Config;
use Ddd\Framework\Exception\FrameworkException;
use PDO;
use PDOStatement;

final class PDODatabase implements Database
{
    private static array $connections;
    private readonly string $connectionName;
    private readonly PDO $connection;
    private ?PDOStatement $lastStatement;

    public function __construct(Config $databaseConfig)
    {
        if (!$databaseConfig->exist('URL') || !$databaseConfig->exist('USER') || !$databaseConfig->exist('PASSWORD')) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw new FrameworkException("Config for database {$databaseConfig->getName()} must have URL, USER & PASSWORD parameter!");
        }

        $this->connectionName = $databaseConfig->getName();
        $this->connection = new PDO(
            $databaseConfig->get('URL'),
            $databaseConfig->get('USER'),
            $databaseConfig->get('PASSWORD')
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getConnection(Config $databaseConfig): self
    {
        if (isset(self::$connections[$databaseConfig->getName()])) {
            return self::$connections[$databaseConfig->getName()];
        }

        self::$connections[$databaseConfig->getName()] = new PDODatabase($databaseConfig);
        return self::$connections[$databaseConfig->getName()];
    }

    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    public function query(string $query): void
    {
        $this->connection->exec($query);
    }

    public function prepare(string $query): void
    {
        $this->lastStatement = $this->connection->prepare($query);
    }

    public function execute(array $params = []): void
    {
        $this->lastStatement->execute($params);
    }

    public function fetchRowAssoc(): ?array
    {
        $this->lastStatement->setFetchMode(PDO::FETCH_ASSOC);
        $data = $this->lastStatement->fetch();
        return $data === false ? null : $data;
    }

    public function fetchAllAssoc(): ?array
    {
        $this->lastStatement->setFetchMode(PDO::FETCH_ASSOC);
        $data = $this->lastStatement->fetchAll();
        return $data === false ? null : $data;
    }

    public function fetchSingleScalarValue(): ?int
    {
        $value = $this->lastStatement->fetchColumn() ?? null;
        return $value === false ? null : (int) $value;
    }

    public function lastInsertedId(): ?string
    {
        return $this->connection->lastInsertId() ?? null;
    }
}