<?php

namespace core\utils;

class collect
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function make(array $items = []): self
    {
        return new self($items);
    }

    public function all(): array
    {
        return $this->items;
    }

    public function get(int|string $key, $default = null)
    {
        return $this->items[$key] ?? $default;
    }

    public function has(int|string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    public function in(mixed $needle): bool
    {
        return in_array($needle, $this->items);
    }

    public function add(int|string $key, $value): self
    {
        $this->items[$key] = $value;
        return $this;
    }

    public function remove(int|string $key): self
    {
        unset($this->items[$key]);
        return $this;
    }

    public function filter(callable $callback): self
    {
        return new self(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    public function map(callable $callback): self
    {
        return new self(array_map($callback, $this->items));
    }

    public function mapK(callable $callback): self
    {
        $result = [];
        foreach ($this->items as $key => $value) {
            $mapped = $callback($value, $key);
            foreach ($mapped as $newKey => $newValue) {
                $result[$newKey] = $newValue;
            }
        }
        return new self($result);
    }

    public function pluck(string $key): self
    {
        $results = array_map(fn ($item) => is_array($item) ? $item[$key] ?? null : (is_object($item) ? $item->$key ?? null : null), $this->items);
        return new self(array_filter($results));
    }

    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    public function find(callable $callback, $default = null)
    {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
        return $default;
    }

    public function where(string $key, $value): self
    {
        return new self(array_filter($this->items, fn ($item) => is_array($item) && ($item[$key] ?? null) === $value));
    }

    public function first(callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return $this->items[0] ?? $default;
        }

        foreach ($this->items as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    public function last(callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return $this->items[count($this->items) - 1] ?? $default;
        }

        foreach (array_reverse($this->items, true) as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function toJson(): string
    {
        return json_encode($this->items);
    }
}
