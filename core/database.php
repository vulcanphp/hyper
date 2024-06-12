<?php

namespace core;

use Exception;
use PDO;

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

    public function __call(string $name, array $args)
    {
        if (!method_exists($this->getPdo(), $name)) {
            throw new Exception(sprintf('Undefined Method (%s) In Query', $name));
        }
        return call_user_func_array([$this->getPdo(), $name], $args);
    }

    public function resetPdo(): self
    {
        $this->pdo = new PDO(
            $this->buildDsn(),
            $this->config['user'] ?? null,
            $this->config['password'] ?? null,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
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
