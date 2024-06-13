<?php

namespace core\utils;

use RuntimeException;

class cache
{
    protected string $cachePath;
    protected array $cacheData = [];
    protected bool $erased = false, $cached = false;

    public function __construct(protected string $name)
    {
        $cacheDir = root_dir('public/tmp');
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        } elseif (!is_writable($cacheDir)) {
            throw new RuntimeException("Cache directory is not writable.");
        }
        $this->cachePath = $cacheDir . '/' . md5($name) . '.cache';
    }

    public function reload(): self
    {
        if (!$this->cached) {
            $this->cached = true;
            $this->cacheData = file_exists($this->cachePath)
                ? json_decode(file_get_contents($this->cachePath), true)
                : [];
            debugger('cache', "cache loaded for:{$this->name} on: {$this->cachePath}");
        }
        return $this;
    }

    public function has(string $key, bool $eraseExpired = false): bool
    {
        $this->reload();
        if ($eraseExpired) {
            $this->eraseExpired();
        }
        return isset($this->cacheData[$key]);
    }

    public function store(string $key, mixed $data, ?string $expire = null): self
    {
        return $this->updateCacheData($key, [
            'time' => time(),
            'expire' => $expire !== null ? strtotime($expire) - time() : 0,
            'data' => serialize($data),
        ]);
    }

    public function load(string $key, callable $callback, ?string $expire = null): mixed
    {
        if ($expire !== null) {
            $this->eraseExpired();
        }
        if (!$this->has($key)) {
            $this->store($key, call_user_func($callback), $expire);
        }
        return $this->retrieve($key);
    }

    public function retrieve(string|array $keys, bool $eraseExpired = false): mixed
    {
        if ($eraseExpired) {
            $this->eraseExpired();
        }
        $results = [];
        foreach ((array)$keys as $key) {
            if ($this->has($key)) {
                $results[$key] = unserialize($this->getCacheData($key)['data']);
            }
        }
        return is_array($keys) ? $results : ($results[$keys] ?? null);
    }

    public function retrieveAll(bool $eraseExpired = false): array
    {
        if ($eraseExpired) {
            $this->eraseExpired();
        }
        return array_map(fn ($entry) => unserialize($entry['data']), $this->getCacheData());
    }

    public function erase(string|array $keys): self
    {
        foreach ((array)$keys as $key) {
            $this->unsetCache($key);
        }
        return $this->saveCacheFile();
    }

    public function eraseExpired(): self
    {
        if (!$this->erased) {
            $this->erased = true;
            $this->cacheData = array_filter($this->getCacheData(), fn ($entry) => !$this->isExpired($entry['time'], $entry['expire']));
            $this->saveCacheFile();
        }
        return $this;
    }

    public function flush(): self
    {
        if (file_exists($this->cachePath)) {
            unlink($this->cachePath);
        }
        debugger('cache', "cache flushed for:{$this->name} on: {$this->cachePath}");
        return $this;
    }

    private function getCacheData(?string $key = null): ?array
    {
        $this->reload();
        return $key !== null ? ($this->cacheData[$key] ?? null) : $this->cacheData;
    }

    private function saveCacheFile(): self
    {
        file_put_contents($this->cachePath, json_encode($this->cacheData));
        debugger('cache', "cache saved for:{$this->name} on: {$this->cachePath}");
        return $this;
    }

    private function unsetCache(string $key): self
    {
        $this->reload();
        unset($this->cacheData[$key]);
        return $this;
    }

    private function updateCacheData(string $key, array $data): self
    {
        $this->reload();
        $this->cacheData[$key] = $data;
        return $this->saveCacheFile();
    }

    private function isExpired(int $timestamp, int $expiration): bool
    {
        return $expiration !== 0 && ((time() - $timestamp) > $expiration);
    }
}
