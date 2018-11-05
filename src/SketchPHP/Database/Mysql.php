<?php

namespace Sketch\Database;

class Mysql extends Driver
{
    public function getDsn(): string
    {
        return "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
    }
}
