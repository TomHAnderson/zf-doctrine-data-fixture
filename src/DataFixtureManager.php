<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceManager;

class DataFixtureManager extends ServiceManager implements ObjectManagerAwareInterface
{
    use ProvidesObjectManager;

    /**
     * @var string
     */
    protected $objectManagerAlias;

    /**
     * @var ContainerInterface
     */
    protected $serviceLocator;

    /**
     * Get all data fixtures
     *
     * @return array
     */
    public function getAll(): array
    {
        $fixtures = [];

        foreach ((array)$this->factories as $name => $squishedName) {
            $fixtures[] = $this->get($name);
        }

        return $fixtures;
    }

    /**
     * Get the object manager alias
     *
     * @return string
     */
    public function getObjectManagerAlias(): string
    {
        return $this->objectManagerAlias;
    }

    /**
     * Set the object manager alias
     *
     * @param string $alias
     *
     * @return void
     */
    public function setObjectManagerAlias(string $alias): DataFixtureManager
    {
        $this->objectManagerAlias = $alias;

        return $this;
    }

    /**
     * Get the service locator
     *
     * @return ContainerInterface
     */
    public function getServiceLocator(): ContainerInterface
    {
        return $this->serviceLocator;
    }

    /**
     * Set the service locator
     *
     * @param ContainerInterface $serviceLocator
     *
     * @return void
     */
    public function setServiceLocator(ContainerInterface $serviceLocator): DataFixtureManager
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }
}
