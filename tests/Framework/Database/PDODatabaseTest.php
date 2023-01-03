<?php

namespace Ddd\Tests\Framework\Database;

use Ddd\Framework\Database\PDODatabase;
use Ddd\Tests\Stabs\Framework\ArrayPassedConfig;
use PHPUnit\Framework\TestCase;

class PDODatabaseTest extends TestCase
{
    public function testSuccessConnection()
    {
        PDODatabase::getConnection(new ArrayPassedConfig('database.in.memory', [
            'URL' => 'sqlite::memory:',
            'USER' => null,
            'PASSWORD' => null,
        ]));
        self::assertEquals('executed without error', 'executed without error');
    }

    public function testExceptionWithWrongConfig()
    {
        self::expectExceptionMessage('Config for database database.no.config must have URL, USER & PASSWORD parameter!');
        PDODatabase::getConnection(new ArrayPassedConfig('database.no.config', []));
    }

    public function testExceptionNoConnection()
    {
        self::expectExceptionMessage('SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for test failed: Name or service not known');
        PDODatabase::getConnection(new ArrayPassedConfig('database.not.existed', [
            'URL' => 'mysql:host=test;dbname=test',
            'USER' => 'xxxx',
            'PASSWORD' => 'xxxx',
        ]));
    }

    public function testGetConnectionName()
    {
        $connection = PDODatabase::getConnection(new ArrayPassedConfig('database.in.memory', [
            'URL' => 'sqlite::memory:',
            'USER' => null,
            'PASSWORD' => null,
        ]));
        self::assertEquals('database.in.memory', $connection->getConnectionName());
    }

    public function testStatements()
    {
        $connection = PDODatabase::getConnection(new ArrayPassedConfig('database.in.memory', [
            'URL' => 'sqlite::memory:',
            'USER' => null,
            'PASSWORD' => null,
        ]));

        $connection->query('CREATE TABLE post (id int, name varchar(255));');
        $connection->prepare("INSERT INTO post VALUES (:id, :name);");

        $connection->execute(['id' => 1, 'name' => 'name1']);
        $connection->execute(['id' => 2, 'name' => 'name2']);

        self::assertEquals(2, $connection->lastInsertedId());

        $connection->prepare("SELECT COUNT(*) as cnt FROM post WHERE 1;");
        $connection->execute();
        $count = $connection->fetchSingleScalarValue();
        self::assertEquals(2, $count);

        $connection->prepare("SELECT * FROM post");
        $connection->execute();
        $row = $connection->fetchRowAssoc();
        self::assertArrayHasKey('id', $row);
        self::assertEquals('1', $row['id']);
        $row = $connection->fetchRowAssoc();
        self::assertArrayHasKey('id', $row);
        self::assertEquals('2', $row['id']);
        $row = $connection->fetchRowAssoc();
        self::assertNull($row);

        $connection->prepare("SELECT * FROM post");
        $connection->execute();
        $data = $connection->fetchAllAssoc();
        self::assertCount(2, $data);
        self::assertEquals('1', $data[0]['id']);
    }
}