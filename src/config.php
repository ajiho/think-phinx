<?php

return [

    // 路径
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds'
    ],

    // 环境配置
    'environments' => [
        //迁移日志表名称
        'default_migration_table' => 'migrations',
        //默认的环境
        'default_environment' => 'development',
        //开发环境
        'development' => [
            'adapter' => env('database.type', 'mysql'),
            'host' => env('database.hostname', '127.0.0.1'),
            'name' => env('database.database', ''),
            'user' => env('database.username', 'root'),
            'pass' => env('database.password', ''),
            'port' => env('database.hostport', '3306'),
            'charset' => env('database.charset', 'utf8mb4'),
            'collation' => env('database.collation'),
            'table_prefix' => env('database.prefix', ''),
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'table_prefix' => 'prod_',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'table_prefix' => 'test_',
        ],
        // 更多的数据库配置信息
    ],

    // 版本顺序规则 creation:迁移按其创建时间排序  execution:迁移按其执行时间排序
    'version_order' => 'creation',

    // faker本地化
    'faker_locale' => 'zh_CN',
];
