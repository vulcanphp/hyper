<?php

namespace core;

use Exception;
use PDO;
use PDOStatement;

class database
{
    public function __construct(public array $config = [], public ?PDO $pdo = null)
    {
    }

    public function getPdo(): PDO
    {
        if ($this->pdo === null) {
            $this->resetPdo();
        }
        return $this->pdo;
    }

    public function query($statement, int|null $fetchMode = null, ...$fetch_mode_args): PDOStatement|false
    {
        debugger('query', $statement);
        return $this->getPdo()->query($statement, $fetchMode, ...$fetch_mode_args);
    }

    public function prepare(string $statement, array $options = []): PDOStatement|false
    {
        debugger('query', $statement);
        return $this->getPdo()->prepare($statement, $options);
    }

    public function __call(string $name, array $args)
    {
        if (!method_exists($this->getPdo(), $name)) {
            throw new Exception(sprintf('Undefined Method (%s) In Query', $name));
        }
        debugger('query', $args);
        return call_user_func_array([$this->getPdo(), $name], $args);
    }

    public function resetPdo(): self
    {
        $dsn = $this->buildDsn();
        $this->pdo = new PDO(
            $dsn,
            $this->config['user'] ?? null,
            $this->config['password'] ?? null,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        debugger('app', "database initialized for: {$dsn}");
        return $this;
    }

    private function buildDsn(): string
    {
        return match ($this->config['driver'] ?? 'mysql') {
            'sqlite' => sprintf('sqlite:%s', $this->config['file'] ?? throw new Exception('SQLite (file) not specified')),
            default => sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s;',
                $this->config['driver'] ?? 'mysql',
                $this->config['host'] ?? '',
                $this->config['port'] ?? '',
                $this->config['name'] ?? '',
                $this->config['charset'] ?? 'utf8mb4'
            ),
        };
    }
}
