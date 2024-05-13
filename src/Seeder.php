<?php

namespace ajiho\phinx;

use Phinx\Seed\AbstractSeed;
class Seeder extends AbstractSeed
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