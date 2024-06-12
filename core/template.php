<?php

namespace core;

class template
{
    private array $context = [];
    private ?string $layout = null;

    public function set(string $key, mixed $value): self
    {
        $this->context[$key] = $value;
        return $this;
    }

    public function layout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    public function render(string $template, array $context = []): string
    {
        $content = $this->template($template, $context);

        if ($this->layout) {
            return $this->template($this->layout, ['content' => $content]);
        }

        return $content;
    }

    public function template(string $template, array $context = []): string
    {
        $context = array_merge($this->context, $context);

        // Ensure the context variables are available in the template
        extract($context);

        ob_start();
        include application::$app->path . '/app/templates/' . rtrim($template, '.php') . '.php';
        return ob_get_clean();
    }
}
