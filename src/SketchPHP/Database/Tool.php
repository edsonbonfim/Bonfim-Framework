<?php

namespace Sketch\Database;

/**
 * Trait Tool
 * @package Keep
 */
trait Tool
{
    /**
     * @param array $columns
     * @return string
     */
    public static function columns(array $columns): string
    {
        return implode('`, `', $columns);
    }

    /**
     * @param array $attributes
     * @return string
     */
    public static function getAttributesKey(array $attributes): string
    {
        return implode('`, `', array_keys($attributes));
    }

    /**
     * @param array $attributes
     * @return string
     */
    public static function getAttributesValue(array $attributes): string
    {
        return implode(', :', array_keys($attributes));
    }
}
