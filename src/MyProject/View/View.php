<?php

namespace MyProject\View;

class View
{
    protected string $path;

    protected $vars = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function setVars(string $name, $value): void
    {
        $this->vars[$name] = $value;
    }

    public function renderHtml(string $template, array $vars = [], int $code = 200)
    {
        http_response_code($code);
        extract($this->vars);
        extract($vars);

        ob_start();
        include $this->path . '/' . $template;
        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }
}
