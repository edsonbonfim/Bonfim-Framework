<?php

namespace Sketch\Database;

/**
 * Class Driver
 * @package Keep
 */
abstract class Driver
{
    /**
     * @var
     */
    protected $host;

    /**
     * @var int
     */
    protected $port = 80;

    /**
     * @var
     */
    protected $dbname;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $pass;

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * @return string
     */
    abstract public function getDsn(): string;

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @param string $dbname
     */
    public function setDbname(string $dbname): void
    {
        $this->dbname = $dbname;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @param string $charset
     */
    public function setCharset(string $charset): void
    {
        $this->charset = $charset;
    }
}
