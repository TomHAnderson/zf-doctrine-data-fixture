<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    ConsoleUsageProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getConsoleUsage(Console $console): array
    {
        return [
            'data-fixture:help'
                => 'Data Fixtures Help',
            'data-fixture:list [<group>]'
                => 'List Data Fixtures',
            'data-fixture:import <group> [--append] [--purge-with-truncate]'
                => 'Import Data Fixtures',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        $configProvider = new ConfigProvider();

        return [
            'service_manager' => $configProvider->getDependencies(),
            'controllers' => $configProvider->getControllerDependencyConfig(),
            'console' => [
                'router' => $configProvider->getConsoleRouterConfig(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAutoloaderConfig(): array
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }
}
