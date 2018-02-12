<?php

declare(strict_types = 1);

namespace ZF\Doctrine\DataFixture\Controller;

use Zend\Mvc\Console\Controller\AbstractConsoleController;

class HelpController extends AbstractConsoleController
{
    /**
     * Outputs this module's usage
     *
     * @return void
     */
    public function helpAction(): void
    {
        $help
            = <<<EOF
Usage:
    data-fixture:import group_name

Options:
    --purge-with-truncate
        If specified will purge the object manager's tables using truncate
        before running fixtures.

    --append
        Will append values to the tables.  If you are re-running fixtures be
        sure to use this.  If you do not specify this option the object
        manager's tables will be emptied!

EOF;

        $this->getConsole()->write($help);
    }
}
