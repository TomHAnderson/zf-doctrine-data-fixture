<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZF\Doctrine\DataFixture\DataFixtureManager;

class ImportControllerFactory implements FactoryInterface
{

    /**
     * @inheritdoc
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): ImportController {
        $dataFixtureManager
                  = $container->get(DataFixtureManager::class);
        $instance = new ImportController($dataFixtureManager);

        return $instance;
    }
}
