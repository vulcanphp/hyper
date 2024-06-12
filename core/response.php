<?php

namespace core;

class response
{
    public function __construct(
        public string $content = '',
        public int $statusCode = 200,
        public array $headers = []
    ) {
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function write(string $content): self
    {
        $this->content .= $content;
        return $this;
    }

    public function json(array $data, int $statusCode = 200): self
    {
        $this->setStatusCode($statusCode);
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->setContent(
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
        return $this;
    }

    public function redirect(string $url, bool $replace = true, int $httpCode = 0): void
    {
        header("Location: $url", $replace, $httpCode);
        exit;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        echo $this->content;
    }
}
