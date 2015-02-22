<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Svn;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Svn\SvnVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class ChangeBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $results = array(
            new ShellResult(
                0,
                'feat-new-awesome' . PHP_EOL,
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('feat-new-awesome');

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'branches'
                )
            ),
            $commandExecutor->getArguments()
        );
    }

    public function testTrunk()
    {
        $results = array(
            new ShellResult(
                0,
                'feat-new-awesome' . PHP_EOL,
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('trunk');

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'branches'
                )
            ),
            $commandExecutor->getArguments()
        );
    }

    public function testBranchDoesntExist()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'Branch named "feat-new-badness" not found.'
        );

        $results = array(
            new ShellResult(
                0,
                'feat-new-awesome' . PHP_EOL,
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('feat-new-badness');
    }
}
