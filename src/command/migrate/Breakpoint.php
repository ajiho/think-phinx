<?php

namespace ajiho\phinx\command\migrate;

use Phinx\Console\PhinxApplication;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Breakpoint extends Command
{
    protected function configure()
    {
        $this->setName('migrate:breakpoint')
            ->addOption('environment', 'e', Option::VALUE_OPTIONAL, 'The target environment.')
            ->addOption('target', 't', Option::VALUE_OPTIONAL, 'The version number to target for the breakpoint')
            ->addOption('set', 's', Option::VALUE_OPTIONAL, 'Set the breakpoint')
            ->addOption('unset', 'u', Option::VALUE_OPTIONAL, 'Unset the breakpoint')
            ->addOption('remove-all', 'r', Option::VALUE_NONE, 'Remove all breakpoints')
            ->setDescription('Run the phinx [Breakpoint] command');
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
        if ($input->hasOption('set')) {
            $arguments += ['--set' => $input->getOption('set')];
        }
        if ($input->hasOption('unset')) {
            $arguments += ['--unset' => $input->getOption('unset')];
        }
        if ($input->hasOption('remove-all')) {
            $arguments += ['--remove-all' => $input->getOption('remove-all')];
        }
        $this->call('breakpoint', $arguments);
    }
}
