<?php

namespace ajiho\phinx\command\seed;

use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Create extends Command
{
    protected function configure()
    {
        $this->setName('seed:create')
            ->addArgument('name', Argument::OPTIONAL, 'What is the name of the seeder?')
            ->setDescription('Run the phinx [Seed Create] command')
            ->setHelp(sprintf('%sCreates a new database seeder%s', PHP_EOL, PHP_EOL));
    }
    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getArgument('name'));
        if (empty($name)) {
            $this->output->error('The name of the file cannot be empty. Please use CamelCase format.');
            return;
        }
        $arguments = ['name' => $name, '--template' => $this->app->get('path.stubs.seed')];
        $this->call('seed:create', $arguments);
    }
}
