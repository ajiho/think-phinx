<?php

namespace ajiho\phinx\command\migrate;

use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Rollback extends Command
{
    protected function configure()
    {
        return $this->setName('migrate:rollback')
            ->addOption('environment', 'e', Option::VALUE_OPTIONAL, 'The target environment')
            ->addOption('target', 't', Option::VALUE_OPTIONAL, 'The version number to rollback to')
            ->addOption('date', 'd', Option::VALUE_OPTIONAL, 'The date to rollback to')
            ->addOption('force', 'f', Option::VALUE_NONE, 'Force rollback to ignore breakpoints')
            ->addOption('dry-run', 'x', Option::VALUE_NONE, 'Dump query to standard output instead of executing it')
            ->addOption('fake', null, Option::VALUE_NONE, "Mark any rollbacks selected as run, but don't actually execute them")
            ->setDescription('Run the phinx [Rollback] command')->setHelp(<<<EOT
The <info>rollback</info> command reverts the last migration, or optionally up to a specific version

<info>phinx rollback -e development</info>
<info>phinx rollback -e development -t 20111018185412</info>
<info>phinx rollback -e development -d 20111018</info>
<info>phinx rollback -e development -v</info>
<info>phinx rollback -e development -t 20111018185412 -f</info>

If you have a breakpoint set, then you can rollback to target 0 and the rollbacks will stop at the breakpoint.
<info>phinx rollback -e development -t 0 </info>

The <info>version_order</info> configuration option is used to determine the order of the migrations when rolling back.
This can be used to allow the rolling back of the last executed migration instead of the last created one, or combined
with the <info>-d|--date</info> option to rollback to a certain date using the migration start times to order them.

EOT
);
    }
    protected function execute(Input $input, Output $output)
    {
        $arguments = [];
        if ($input->hasOption('environment')) {
            $arguments += ['--environment' => $input->getOption('environment')];
        }
        if ($input->hasOption('target')) {
            $arguments += ['--target' => $input->getOption('target')];
        }
        if ($input->hasOption('date')) {
            $arguments += ['--date' => $input->getOption('date')];
        }
        if ($input->hasOption('force')) {
            $arguments += ['--force' => $input->getOption('force')];
        }
        if ($input->hasOption('dry-run')) {
            $arguments += ['--dry-run' => $input->getOption('dry-run')];
        }
        if ($input->hasOption('fake')) {
            $arguments += ['--fake' => $input->getOption('fake')];
        }
        $this->call('rollback', $arguments);
    }
}
