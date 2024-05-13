<?php

namespace ajiho\phinx\command\migrate;

use think\console\Input;
use think\console\input\Option;
use think\console\Output;
use ajiho\phinx\Command;
class Status extends Command
{
    protected function configure()
    {
        return $this->setName('migrate:status')
            ->addOption('environment', 'e', Option::VALUE_OPTIONAL, 'The target environment.')
            ->addOption('format', 'f', Option::VALUE_OPTIONAL, 'The output format: text or json. Defaults to text.', 'text')
            ->setDescription('Run the phinx [Status] command')->setHelp(<<<EOT
The <info>status</info> command prints a list of all migrations, along with their current status

<info>phinx status -e development</info>
<info>phinx status -e development -f json</info>

The <info>version_order</info> configuration option is used to determine the order of the status migrations.
EOT
);
    }
    protected function execute(Input $input, Output $output)
    {
        $arguments = [];
        if ($input->hasOption('environment')) {
            $arguments += ['--environment' => $input->getOption('environment')];
        }
        if ($input->hasOption('format')) {
            $arguments += ['--format' => $input->getOption('format')];
        }
        $this->call('status', $arguments);
    }
}
