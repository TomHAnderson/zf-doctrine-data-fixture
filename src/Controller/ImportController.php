<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Zend\Mvc\Console\Controller\AbstractConsoleController;
use ZF\Doctrine\DataFixture\DataFixtureManager;
use ZF\Doctrine\DataFixture\Loader;
use RuntimeException;

class ImportController extends AbstractConsoleController
{
    /**
     * @var DataFixtureManager
     */
    protected $dataFixtureManager;

    /**
     * Constructor.
     *
     * @param DataFixtureManager $dataFixtureManager
     */
    public function __construct(DataFixtureManager $dataFixtureManager)
    {
        $this->dataFixtureManager = $dataFixtureManager;
    }

    /**
     * Runs the data-fixture import
     *
     * @return void
     */
    public function importAction(): void
    {
        if ($this->params()->fromRoute('append')) {
            throw new RuntimeException('--append is now the default action');
        }

        $loader = new Loader($this->dataFixtureManager);
        $purger = new ORMPurger();

        foreach ($this->dataFixtureManager->getAll() as $fixture) {
            $loader->addFixture($fixture);
        }

        if ($this->params()->fromRoute('purge-with-truncate')) {
            $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        }

        $executor = new ORMExecutor(
            $this->dataFixtureManager->getObjectManager(),
            $purger
        );
        $executor->execute(
            $loader->getFixtures(),
            (bool) ! $this->params()->fromRoute('do-not-append')
        );
    }
}
