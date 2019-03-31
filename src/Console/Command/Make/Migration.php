<?php

namespace Bonfim\Framework\Console\Command\Make;

use ICanBoogie\Inflector;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends Command
{
    protected static $defaultName = 'make:migration';

    protected function configure()
    {
        $this
            ->setDescription('Create a new migration file.')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $class = Inflector::get()->singularize($name) . 'Schema';
        $table = strtolower(Inflector::get()->pluralize($name));

        $base = file_get_contents(getcwd().'/src/base/migration.txt');
        $base = str_replace(['@class', '@table'], [$class, $table], $base);

        $this->write("/database/Migrations/$class.php", $base);

        $output->writeln("created database/Migrations/$class.php");
    }

    private function write(string $fname, string $content)
    {
        $file = fopen(getcwd().$fname, 'w+');
        fwrite($file, $content);
        fclose($file);
    }
}
