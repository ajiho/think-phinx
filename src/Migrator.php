<?php

namespace ajiho\phinx;

use Phinx\Migration\AbstractMigration;
class Migrator extends AbstractMigration
{
    use AttributeInitializer;
    public final function init()
    {
        $this->attributeInit();
        $this->initialize();
    }
    protected function initialize()
    {
    }
}