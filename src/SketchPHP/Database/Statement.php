<?php

namespace Sketch\Database;

/**
 * Trait Statement
 * @package Keep
 */
trait Statement
{
    /**
     * @var
     */
    private $statement;
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string $table
     * @param array $attributes
     * @return self
     */
    public function create(string $table, array $attributes): self
    {
        $this->attributes = $attributes;
        $this->statement  = 'INSERT INTO `' . $table . '` (`';
        $this->statement .= Tool::getAttributesKey($attributes);
        $this->statement .= '`) VALUES (:';
        $this->statement .= Tool::getAttributesValue($attributes) . ')';

        return $this;
    }

    /**
     * @param string $table
     * @return self
     */
    public function all(string $table): self
    {
        $this->statement = "SELECT * FROM `{$table}`";
        return $this;
    }

    /**
     * @param string $table
     * @param array $columns
     * @return self
     */
    public function select(string $table, array $columns): self
    {
        $this->statement = 'SELECT `' . Tool::columns($columns) . "` FROM `{$table}`";
        return $this;
    }

    /**
     * @param string $table
     * @param array $attributes
     * @return self
     */
    public function update(string $table, array $attributes): self
    {
        $this->attributes = $attributes;

        $set = '';
        $key = array_keys($attributes);
        $pop = array_pop($key);

        foreach ($attributes as $key => $value) {
            $set .= ($key == $pop) ? '' : "`{$key}` = :{$key}, ";
        }

        $set .= "`{$pop}` = :{$pop}";

        $this->statement = "UPDATE `{$table}` SET {$set}";

        return $this;
    }

    /**
     * @param string $table
     * @return self
     */
    public function delete(string $table): self
    {
        $this->statement = "DELETE FROM `{$table}`";
        return $this;
    }
}
