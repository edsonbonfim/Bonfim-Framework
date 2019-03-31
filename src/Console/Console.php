<?php

namespace Bonfim\Framework\Console;

use Symfony\Component\Console\Application;

class Console
{
    private $app;

    public function __construct()
    {
        $this->app = new Application();
    }

    public function run(): int
    {
        $this->app->addCommands([
            new Command\Make\Migration,
            new Command\Migration\Run
        ]);

        return $this->app->run();
    }
}
