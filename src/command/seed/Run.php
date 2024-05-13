<?php

namespace ajiho\phinx\command\seed;

use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Run extends Command
{
    protected function configure()
    {
        $this->setName('seed:run')
            ->addOption('environment', 'e', Option::VALUE_OPTIONAL, 'The target environment')
            ->addOption('seed', 's', Option::VALUE_OPTIONAL | Option::VALUE_IS_ARRAY, 'What is the name of the seeder?')
            ->setDescription('Run the phinx [Seed Run] command')
            ->setHelp(<<<EOT
The <info>seed:run</info> command runs all available or individual seeders

<info>phinx seed:run -e development</info>
<info>phinx seed:run -e development -s UserSeeder</info>
<info>phinx seed:run -e development -s UserSeeder -s PermissionSeeder -s LogSeeder</info>
<info>phinx seed:run -e development -v</info>

EOT
);
    }
    protected function execute(Input $input, Output $output)
    {
        $arguments = [];
        if ($input->hasOption('environment')) {
            $arguments += ['--environment' => $input->getOption('environment')];
        }
        if ($input->hasOption('seed')) {
            $arguments += ['--seed' => $input->getOption('seed')];
        }
        $this->call('seed:run', $arguments);
    }
}
