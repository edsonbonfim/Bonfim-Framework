<?php

namespace Sketch\Database;

/**
 * Trait Keyword
 * @package Keep
 */
trait Keyword
{
    /**
     * @var string
     */
    private $keyword = '';

    /**
     * @param array $columns
     * @param $order
     * @return self
     */
    public function orderBy(array $columns, $order): self
    {
        $this->keyword = 'ORDER BY `' . Tool::columns($columns) . "` {$order}";
        return $this;
    }
}
