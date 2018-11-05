<?php

namespace Sketch\Database;

/**
 * Trait Clause
 * @package Keep
 */
trait Clause
{
    /**
     * @var string
     */
    private $clause = '';

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string $key
     * @param $value
     * @return self
     */
    public function where(string $key, $value): self
    {
        $this->attributes[$key] = $value;
        $this->clause = "WHERE `{$key}` = :{$key}";
        return $this;
    }
}
