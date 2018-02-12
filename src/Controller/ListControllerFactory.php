<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZF\Doctrine\DataFixture\DataFixtureManager;

class ListControllerFactory implements FactoryInterface
{

    /**
     * @inheritdoc
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): ListController {
        $dataFixtureManager = null;

        $request = $container->get('Request');
        $config  = $container->get('Config');
        $console = $container->get('Console');

        // If an object manager and group are specified include the data fixture manager
        if ($request->params()->get(1)) {
            $dataFixtureManager = $container->get(DataFixtureManager::class);
        }

        $instance = new ListController(
            (array)$config['doctrine']['fixture'],
            $console,
            $dataFixtureManager
        );

        return $instance;
    }
}
