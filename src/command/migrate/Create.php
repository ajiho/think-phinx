<?php

namespace ajiho\phinx\command\migrate;

use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Create extends Command
{
    protected function configure()
    {
        $this->setName('migrate:create')
            ->addArgument('name', Argument::OPTIONAL, 'Class name of the migration (in CamelCase)')
            ->setHelp(sprintf('%sCreates a new database migration%s', PHP_EOL, PHP_EOL))
            ->setDescription('Run the phinx [Create] command');
    }
    protected function execute(Input $input, Output $output)
    {
        $name = trim($input->getArgument('name'));
        $arguments = ['name' => $name, '--template' => $this->app->get('path.stubs.migrate')];
        $this->call('create', $arguments);
    }
}
