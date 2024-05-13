<?php

namespace ajiho\phinx\command\migrate;

use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Run extends Command
{
    protected function configure()
    {
        return $this->setName('migrate:run')
            ->addOption('environment', 'e', Option::VALUE_OPTIONAL, 'The target environment')
            ->addOption('date', 'd', Option::VALUE_OPTIONAL, 'The date to migrate to')
            ->addOption('target', 't', Option::VALUE_OPTIONAL, 'The version number to migrate to')
            ->addOption('dry-run', 'x', Option::VALUE_NONE, 'Dump query to standard output instead of executing it')
            ->addOption('fake', null, Option::VALUE_NONE, "Mark any rollbacks selected as run, but don't actually execute them")
            ->setDescription('Run the phinx [Migrate] command')->setHelp(<<<EOT
The <info>migrate</info> command runs all available migrations, optionally up to a specific version

<info>phinx migrate -e development</info>
<info>phinx migrate -e development -t 20110103081132</info>
<info>phinx migrate -e development -d 20110103</info>
<info>phinx migrate -e development -v</info>

EOT
);
    }
    protected function execute(Input $input, Output $output)
    {
        $arguments = [];
        if ($input->hasOption('environment')) {
            $arguments += ['--environment' => $input->getOption('environment')];
        }
        if ($input->hasOption('date')) {
            $arguments += ['--date' => $input->getOption('date')];
        }
        if ($input->hasOption('target')) {
            $arguments += ['--target' => $input->getOption('target')];
        }
        if ($input->hasOption('dry-run')) {
            $arguments += ['--dry-run' => $input->getOption('dry-run')];
        }
        if ($input->hasOption('fake')) {
            $arguments += ['--fake' => $input->getOption('fake')];
        }
        $this->call('migrate', $arguments);
    }
}
