<?php

namespace ajiho\phinx;

use ajiho\phinx\command\migrate\Breakpoint as MigrateBreakpoint;
use ajiho\phinx\command\migrate\Create as MigrateCreate;
use ajiho\phinx\command\migrate\Rollback as MigrateRollback;
use ajiho\phinx\command\migrate\Run as MigrateRun;
use ajiho\phinx\command\migrate\Status as MigrateStatus;
use ajiho\phinx\command\seed\Create as SeedCreate;
use ajiho\phinx\command\seed\Run as SeedRun;

class Service extends \think\Service
{
    public function boot()
    {
        $this->commands([
            MigrateCreate::class,
            MigrateRun::class,
            MigrateRollback::class,
            MigrateBreakpoint::class,
            MigrateStatus::class,
            SeedCreate::class,
            SeedRun::class
        ]);
    }
}
