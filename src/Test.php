<?php

namespace ajiho\phinx;

use ajiho\namespaceify\Parser;

class Test
{
    public static function run()
    {
        $start = microtime(true);
        $filename = dirname(__DIR__) . '/vendor/cakephp/core/functions.php';
        $pkgDir = dirname(__DIR__) . '/vendor/cakephp';
        $parser = new Parser($pkgDir, $filename, 'Cake\Core');
        $parser->run();
        $end = microtime(true);
        $elapsed = $end - $start;
        echo "执行时间：{$elapsed} 秒\n";
    }
}
