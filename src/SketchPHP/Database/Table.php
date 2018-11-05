<?php

namespace Sketch\Database;

/**
 * Trait Table
 * @package Keep
 */
trait Table
{
    /**
     * @var
     */
    private $table;

    /**
     * @return Database
     */
    public function setTable(): Database
    {
        return $this;
    }
}
