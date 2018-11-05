<?php

namespace Sketch\Database;

/**
 * Trait Operators
 * @package Keep
 */
trait Operators
{
    /**
     * @var string
     */

    private $operators = '';
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string|null $key
     * @param $value
     * @return self
     */
    public function and(string $key = null, $value): self
    {
        return (!$key) ? $this : $this->operator('AND', $key, $value);
    }

    /**
     * @param string|null $key
     * @param $value
     * @return self
     */
    public function or(string $key = null, $value): self
    {
        return (!$key) ? $this : $this->operator('OR', $key, $value);
    }

    /**
     * @param string $key
     * @param $value
     * @return self
     */
    public function not(string $key, $value): self
    {
        return $this->operator('NOT', $key, $value);
    }

    /**
     * @param string $operator
     * @param string $key
     * @param $value
     * @return self
     */
    private function operator(string $operator, string $key, $value): self
    {
        $this->attributes[$key] = $value;
        $this->operators .= "{$operator} `{$key}` = :{$key}";
        return $this;
    }
}
