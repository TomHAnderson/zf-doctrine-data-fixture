<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture;

use Interop\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DataFixtureManagerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): DataFixtureManager {

        // Load the fixture group
        $config       = $container->get('config');
        $fixtureGroup = $this->getFixtureGroup($container, $options);
        if (!isset($config['doctrine']['fixture'][$fixtureGroup])) {
            throw new \RuntimeException(sprintf(
                'Fixture group not found: %s',
                $fixtureGroup
            ));
        }

        // Check for object manager
        if (!isset($config['doctrine']['fixture'][$fixtureGroup]['object_manager'])) {
            throw new \RuntimeException(sprintf(
                'Object manager not specified for fixture group %s',
                $fixtureGroup
            ));
        }

        // Load instance
        $objectManagerAlias
            = (string)$config['doctrine']['fixture'][$fixtureGroup]['object_manager'];
        $instance = new DataFixtureManager(
            (array)$config['doctrine']['fixture'][$fixtureGroup]
        );
        $instance->setServiceLocator($container);
        $instance->setObjectManagerAlias($objectManagerAlias);
        $instance->setObjectManager($container->get($objectManagerAlias));

        return $instance;
    }

    /**
     * Get the fixture group name
     *
     * @param ContainerInterface $container
     * @param array|null         $options
     *
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getFixtureGroup(
        ContainerInterface $container,
        array $options = null
    ): string {
        if ($options && isset($options['group']) && $options['group']) {
            return (string)$options['group'];
        }

        return (string)$container->get('Request')->params()->get(1);
    }
}
