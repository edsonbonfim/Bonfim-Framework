<?php

namespace Sketch\Database;

/**
 * Class DB
 * @package Keep
 */
class DB
{
    /**
     * @var null
     */
    private static $db = null;

    /**
     * @var
     */
    private static $driver;

    /**
     * @param string $func
     * @param array $params
     * @return mixed
     */
    public static function __callStatic(string $func, array $params)
    {
        return call_user_func_array([self::singleton(), $func], $params);
    }

    /**
     * @param array $config
     */
    public static function config(array $config)
    {
        switch ($config['driver']) {
            case 'mysql':
                self::mysql($config);
                break;
        }
    }

    public static function conn(): void
    {
        self::singleton()->connection(self::$driver);
    }

    /**
     * @return Database
     */
    public static function singleton(): Database
    {
        if (!isset(self::$db) || is_null(self::$db)) {
            self::$db = new Database;
        }

        return self::$db;
    }

    /**
     * @param array $config
     */
    private static function mysql(array $config): void
    {
        $mysql = new Mysql;
        $mysql->setHost($config['host']);
        $mysql->setDbname($config['dbname']);
        $mysql->setUser($config['user']);
        $mysql->setPass($config['pass']);

        self::$driver = $mysql;
    }
}
