<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture;

class ConfigProvider
{
    /**
     * Return the full configuration
     *
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'controllers'  => $this->getControllerDependencyConfig(),
            'console' => [
                'router' => $this->getConsoleRouterConfig(),
            ],
        ];
    }

    /**
     * Get the dependency configuration
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                DataFixtureManager::class => DataFixtureManagerFactory::class,
            ],
        ];
    }

    /**
     * Get the controller dependency configuration
     *
     * @return array
     */
    public function getControllerDependencyConfig(): array
    {
        return [
            'factories' => [
                Controller\HelpController::class   =>
                    Controller\HelpControllerFactory::class,
                Controller\ImportController::class =>
                    Controller\ImportControllerFactory::class,
                Controller\ListController::class   =>
                    Controller\ListControllerFactory::class,
            ],
        ];
    }

    /**
     * Get the console router configuration
     *
     * @return array
     */
    public function getConsoleRouterConfig(): array
    {
        return [
            'routes' => [
                'zf-doctrine-data-fixture-help' => [
                    'options' => [
                        'route'    => 'data-fixture:help',
                        'defaults' => [
                            'controller' => Controller\HelpController::class,
                            'action'     => 'help',
                        ],
                    ],
                ],

                'zf-doctrine-data-fixture-import' => [
                    'options' => [
                        'route'    => 'data-fixture:import '
                                      . '<fixture-group> [--append] [--do-not-append] [--purge-with-truncate]',
                        'defaults' => [
                            'controller' => Controller\ImportController::class,
                            'action'     => 'import',
                        ],
                    ],
                ],

                'zf-doctrine-data-fixture-list' => [
                    'options' => [
                        'route'    => 'data-fixture:list [<fixture-group>]',
                        'defaults' => [
                            'controller' => Controller\ListController::class,
                            'action'     => 'list',
                        ],
                    ],
                ],
            ],
        ];
    }
}
