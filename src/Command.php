<?php

namespace ajiho\phinx;

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use think\console\Input;
use think\console\Output;

class Command extends \think\console\Command
{
    protected function initialize(Input $input, Output $output)
    {
        parent::initialize($input, $output);
        $stubs_path = __DIR__ . DIRECTORY_SEPARATOR . 'command' . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
        $this->app->instance('path.stubs.migrate', $stubs_path . 'migration.stub');
        $this->app->instance('path.stubs.seed', $stubs_path . 'seed.stub');
    }
    //初始化配置
    protected function initConfig($parameters)
    {
        $config = $this->app->config->get('phinx');
        // 迁移日志表增加前缀逻辑
        $environment = $config['environments']['default_environment'];
        if (array_key_exists('--environment', $parameters)) {
            //如果参数有传递环境变量
            $environment = $parameters['--environment'];
        }
        if (array_key_exists($environment, $config['environments'])) {
            $table_prefix = $config['environments'][$environment]['table_prefix'];
            $config['environments']['default_migration_table'] = $table_prefix . $config['environments']['default_migration_table'];
        }
        $filename = $this->app->getRuntimePath() . 'phinx.json';
        //把配置文件的路径存储到容器中,方便后续使用
        $this->app->instance('path.phinx.configuration', $filename);
        file_put_contents($filename, json_encode($config));
    }
    //创建目录
    protected function mkdir($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    protected function call($name, array $parameters = [])
    {
        $phinx = new PhinxApplication();
        $command = $phinx->find($name);
        //优化1:让phinx日志记录表默认添加上配置的表前缀,这里要判断传入参数中是否携带--environment参数
        $this->initConfig($parameters);
        //配置文件路径
        $configurationPath = $this->app->get('path.phinx.configuration');
        //读取配置
        $config = json_decode(file_get_contents($configurationPath), true);
        //再把已经读取好的配置文件内容再存到容器中方便后续的取用
        $this->app->instance('config.phinx', $config);
        //优化2:根据配置中的路径,如果不存在则自动创建目录,这里需要根据不同的指令来区分
        if ($name === "create") {
            $this->mkdir($config['paths']['migrations']);
        } elseif ($name === "seed:create") {
            $this->mkdir($config['paths']['seeds']);
        }
        //处理每个命令都需要的配置参数
        $commonParam = ['--configuration' => $configurationPath];
        $parameters = array_merge($commonParam, $parameters);
        return $command->run(new ArrayInput($parameters), new ConsoleOutput());
    }
}
