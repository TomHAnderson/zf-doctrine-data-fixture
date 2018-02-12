<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
use Zend\Console\ColorInterface as Color;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use ZF\Doctrine\DataFixture\DataFixtureManager;

class ListController extends AbstractConsoleController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var DataFixtureManager
     */
    protected $dataFixtureManager;

    /**
     * Constructor
     *
     * @param array                   $config
     * @param ConsoleAdapter          $console
     * @param DataFixtureManager|null $dataFixtureManager
     */
    public function __construct(
        array $config,
        ConsoleAdapter $console,
        DataFixtureManager $dataFixtureManager = null
    ) {
        $this->config = $config;
        $this->setConsole($console);
        $this->dataFixtureManager = $dataFixtureManager;
    }

    /**
     * List the fixtures
     */
    public function listAction(): void
    {
        if (!$this->dataFixtureManager) {
            $this->getConsole()->writeLine("All Fixture Groups", Color::RED);

            foreach ($this->config as $group => $smConfig) {
                $this->getConsole()->writeLine("$group", Color::CYAN);
            }

            return;
        }

        $this->getConsole()->write('Group: ', Color::YELLOW);
        $this->getConsole()->writeLine(
            $this->params()
                 ->fromRoute('fixture-group'),
            Color::GREEN
        );
        $this->getConsole()->write('Object Manager: ', Color::YELLOW);
        $this->getConsole()->writeLine(
             $this->dataFixtureManager->getObjectManagerAlias(),
             Color::GREEN
         );

        foreach ($this->dataFixtureManager->getAll() as $fixture) {
            $this->getConsole()->writeLine(
                get_class($fixture),
                Color::CYAN
            );
        }
    }
}
