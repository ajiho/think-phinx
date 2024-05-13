<?php

namespace ajiho\phinx;

use Cake\Database\Query;
use Faker\Factory;
use Faker\Generator;
use think\App;
trait AttributeInitializer
{
    /**
     * @var Generator
     */
    protected $faker;
    /**
     * @var App
     */
    protected $app;
    /**
     * phinx的配置数组
     */
    protected $config;
    /**
     * 当前执行的环境的配置,比如: environments['development']
     */
    protected $environmentConfig;
    
    private function attributeInit()
    {
        $this->app = app();
        $this->config = $this->app->get('config.phinx');
        $this->environmentConfig = $this->config['environments'][$this->getEnvironment()];
        $this->faker = Factory::create($this->config['faker_locale']);
    }
    
    //把getQueryBuilder方法提取出来,这样在seeds种子文件中，可以直接$this->getQueryBuilder()得到Query对象
    public function getQueryBuilder(): Query
    {
        return $this->getAdapter()->getQueryBuilder();
    }
}
