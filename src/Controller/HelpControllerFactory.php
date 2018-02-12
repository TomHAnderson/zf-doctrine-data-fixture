<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class HelpControllerFactory implements FactoryInterface
{

    /**
     * @inheritdoc
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): HelpController {
        $instance = new HelpController;
        $instance->setConsole($container->get('Console'));

        return $instance;
    }
}
