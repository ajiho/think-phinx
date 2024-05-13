# think-phinx

基于phinx封装的一个thinkphp6数据库迁移工具

设计灵感来自于[wdaglb/thinkphp-migration](https://github.com/wdaglb/thinkphp-migration)
并在此基础上进行了大量优化

| think-phinx | phinx   |
|-------------|---------|
| 1.0.0       | ~0.13.0 |


# 特性

- 和tp官方的迁移工具保持相同的命令,无学习成本
- 相对于tp官方的迁移工具,think-phinx支持多数据库(环境,-e选项)迁移
- 相对于tp官方的迁移工具,phinx是直接通过composer更新而不是固定死版本,bug修复还有特性支持交给phinx官方去做，think-phinx只做了一个桥梁的作用
- 集成还在维护的[fakerphp/faker](https://packagist.org/packages/fakerphp/faker)而不是已经被弃用的[fzaninotto/faker](https://packagist.org/packages/fzaninotto/faker)
- 原汁原味的phinx,[phinx的官方文档](https://phinx.org/)内容完全可用
- 相对于`wdaglb/thinkphp-migration`命令的选项不需要两个`--`
- 相对于`wdaglb/thinkphp-migration`会自动创建文件迁移和填充路径,无需手动创建
- 相对于`wdaglb/thinkphp-migration`支持thinkphp6.x
- 相对于`wdaglb/thinkphp-migration`是直接在控制台输出phinx原本的命令信息
- 和phinx官方的命令选项保持一致,比如命令选项简写
- 迁移和填充模板默认有提供示例代码,和laravel的迁移模板一样默认提供up和down方法

# 安装

```bash
composer require ajiho/think-phinx
```

安装过程中会询问你是否确认安装该插件？ `y`

安装完毕后运行`php think`会得到如下信息

```
 migrate
  migrate:breakpoint  Run the phinx [Breakpoint] command
  migrate:create      Run the phinx [Create] command
  migrate:rollback    Run the phinx [Rollback] command
  migrate:run         Run the phinx [Migrate] command
  migrate:status      Run the phinx [Status] command
 seed
  seed:create         Run the phinx [Seed Create] command
  seed:run            Run the phinx [Seed Run] command 
```

# 配置文件


安装完毕后会自动生成配置文件`/config/phinx.php`

```php
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
```

# 命令

和`phinx`官方文档[命令](https://book.cakephp.org/phinx/0/en/commands.html)用法保持一致
如果您想获取每个命令的具体选项您除了查看phinx官方文档外，您还可以使用以下指令进行查看

```bash
php think 指令 -h
```
例如:
```bash
php think migrate:breakpoint -h
```
```
Usage:
  migrate:breakpoint [options]

Options:
  -e, --environment[=ENVIRONMENT]  The target environment.
  -t, --target[=TARGET]            The version number to target for the breakpoint
  -s, --set[=SET]                  Set the breakpoint
  -u, --unset[=UNSET]              Unset the breakpoint
  -r, --remove-all                 Remove all breakpoints
  -h, --help                       Display this help message
  -V, --version                    Display this console version
  -q, --quiet                      Do not output any message
      --ansi                       Force ANSI output
      --no-ansi                    Disable ANSI output
  -n, --no-interaction             Do not ask any interactive question
  -v|vv|vvv, --verbose             Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```


## migrate:create

tips:迁移文件名称必须是大驼峰命名规范

~~~
php think migrate:create CreateUserTable
~~~


## migrate:breakpoint

> Breakpoint 命令用于设置断点，允许您限制回滚。您可以通过不提供任何参数来切换最近迁移的断点。

~~~
php think migrate:breakpoint
php think migrate:breakpoint -e development
php think migrate:breakpoint -e development -t 20230801141644
php think migrate:breakpoint -e development -t 20230801141644 --set
php think migrate:breakpoint -e development -t 20230801141644 --unset
# 删除所有断点
php think migrate:breakpoint -e development -r
~~~


## migrate:rollback

> 不指定任何参数只回退最后一个迁移文件，步长为1

~~~
php think migrate:rollback
~~~

> 指定执行环境，默认环境根据配置文件可以设置

~~~
php think migrate:rollback -e mysql
~~~

> 要将所有迁移回滚到特定版本，请使用-t参数

~~~
php think migrate:rollback -e mysql -t 20230801141644
~~~

> 回滚所有迁移 -t 0

~~~
php think migrate:rollback -e mysql -t 0
~~~


> 要将所有迁移回滚到特定日期，请使用-d参数

~~~
php think migrate:rollback -e development -d 2012
php think migrate:rollback -e development -d 201201
php think migrate:rollback -e development -d 20120103
php think migrate:rollback -e development -d 2012010312
php think migrate:rollback -e development -d 201201031205
php think migrate:rollback -e development -d 20120103120530
~~~

> 设置了断点，阻止了进一步的回滚，您可以使用-f 参数覆盖断点。

~~~
php think migrate:rollback -e development -t 0 -f
~~~

> 将查询打印到标准输出而不执行它们,使用 --dry-run 参数

~~~
php think migrate:rollback --dry-run
php think migrate:rollback -t 0 --dry-run
~~~


## migrate:run

> 默认迁移指定的默认环境和所有的迁移文件

~~~
php think migrate:run
~~~

> 指定环境

~~~
php think migrate:run -e development
php think migrate:run -e testing
php think migrate:run -e production
~~~

> 指定环境同时指定指定的版本或者日期之前的迁移文件

~~~
# 表示只执行到20110103081132迁移文件就结束
php think migrate:run -e development -t 20110103081132
# 表示只执行到2011年1月3号的迁移文件就停止迁移
php think migrate:run -e development -d 20110103
~~~

## migrate:status

> Status 命令打印所有迁移的列表及其当前状态。您可以使用此命令来确定已运行哪些迁移。

~~~
php think migrate:status
php think migrate:status -e development
~~~

## seed:create

PS:建议创建时最好保持一个命名规范`填充文件名+Seeder`,必须是大驼峰命名规范


~~~
php think seed:create UserSeeder
~~~


## seed:run

~~~
php think seed:run
php think seed:run -e development
php think seed:run -e development -s UserSeeder
~~~

> 同时指定多个填充文件,通过 -s 追加

~~~
php think seed:run -s UserSeeder -s PermissionSeeder -s LogSeeder
~~~

> seeder填充文件默认是随机的，有的时候你需要先填充某个表再填充某个表就需要通过`getDependencies()`方法指定特定的顺序进行填充

```php
<?php

use ajiho\phinx\Seeder;


class UserSeeder extends Seeder
{

    //让填充文件按顺序执行
    public function getDependencies()
    {
        return [
            'UserSeeder',
            'ShopItemSeeder'
        ];
    }
    public function run() : void
    {
        //...
    }
}
```


# 文档
- [Phinx EN](https://book.cakephp.org/phinx)
- [Phinx CN](https://tsy12321.gitbooks.io/phinx-doc/content)

