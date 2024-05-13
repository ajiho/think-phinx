<?php

namespace ajiho\phinx;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\DependencyResolver\Operation\UpdateOperation;
use ajiho\namespaceify\Parser;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;
    protected $pkgDir;
    protected $filename;
    protected $namespace;
    protected $targetPkgName = ['ajiho/think-phinx', 'robmorgan/phinx'];

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->pkgDir = $composer->getConfig()->get('vendor-dir') . DIRECTORY_SEPARATOR . 'cakephp';
        $this->filename = $this->pkgDir . '/core/functions.php';
        $this->namespace = 'Cake\Core';
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // 不需要在deactivate做任何逻辑
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // 不需要在uninstall做任何逻辑
    }

    public static function getSubscribedEvents()
    {
        //事件触发
        return [
            //事件名称 => 事件触发方法
            PackageEvents::POST_PACKAGE_UPDATE => 'postPackageUpdate',
            PackageEvents::POST_PACKAGE_INSTALL => 'postPackageInstall',
        ];
    }

    public function postPackageUpdate(PackageEvent $event)
    {
        $operation = $event->getOperation();
        // 检查操作类型是否为更新操作
        if ($operation instanceof UpdateOperation) {
            // 获取被更新的包的名称
            $packageName = $operation->getInitialPackage()->getName();
            $this->modify($packageName);
        }
    }

    public function postPackageInstall(PackageEvent $event)
    {
        $package = $event->getOperation()->getPackage();
        $packageName = $package->getName();
        $this->modify($packageName);
    }

    public function modify($packageName)
    {
        if (in_array($packageName, $this->targetPkgName)) {
            (new Parser($this->pkgDir, $this->filename, $this->namespace))->run();
        }
    }
}
