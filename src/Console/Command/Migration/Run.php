<?php

namespace Bonfim\Framework\Console\Command\Migration;

use ICanBoogie\Inflector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Run extends Command
{
    protected static $defaultName = 'migration:run';

    protected function configure()
    {
        $this
            ->setDescription('Run all pending migrations.')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = 'Database\Migrations\\' . $input->getArgument('name') . 'Schema';
        $schema = new $name;
        $schema->up();
        $schema->run();
        $output->writeln('Database migrated successfully');
    }
}
