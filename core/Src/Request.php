<?php

namespace Src;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;
    protected array $files;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?? [];
        $this->files = $_FILES;
    }

    // Добавляем метод для проверки наличия файла
    public function hasFile(string $name): bool
    {
        return isset($this->files[$name]) && $this->files[$name]['error'] === UPLOAD_ERR_OK;
    }

    // Добавляем метод для получения файла
    public function file(string $name)
    {
        return $this->files[$name] ?? null;
    }

    // Остальные методы класса...
    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($field, $value): void
    {
        $this->body[$field] = $value;
    }

    public function get($field)
    {
        return $this->body[$field] ?? null;
    }

    public function files(): array
    {
        return $this->files;
    }

    public function __get($key)
    {
        return $this->body[$key] ?? null;
    }
}