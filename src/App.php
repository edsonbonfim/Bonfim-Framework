<?php

namespace Bonfim\Framework;

class App
{
    private $path;

    public function __construct()
    {
        $this->path = getcwd();

        include "$this->path/config/facades.php";
        include "$this->path/config/app.php";
    }

    public function run()
    {
        include "$this->path/start/routes.php";
    }

    public function console(): int
    {
        $console = new Console\Console;
        return $console->run();
    }
}
