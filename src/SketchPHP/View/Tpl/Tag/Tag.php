<?php

namespace Sketch\View\Tpl\Tag;

abstract class Tag
{
    protected static $blocks = [];
    protected static $config;
    
    private static $content;

    private $search;

    protected function replace(string $replace): void
    {
        self::$content = str_replace($this->search, $replace, self::$content);
    }

    protected function match($pattern, $callback): void
    {
        if (preg_match_all($pattern, self::getContent(), $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                
                $this->search = $match[0];

                unset($match[0]);

                call_user_func_array($callback, array_filter($match));
            }
        }
    }

    public static function setContent(string $content): void
    {
        self::$content = $content;
    }

    public static function getContent(): string
    {
        return self::$content;
    }

    public static function setConfig(array $config): void
    {
        self::$config = $config;
    }

    public static function getConfig(): array
    {
        return self::$config;
    }
}
