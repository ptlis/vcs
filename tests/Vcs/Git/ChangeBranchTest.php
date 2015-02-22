<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Git;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Git\GitVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class ChangeBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $results = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/git_branch')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/git_branch_switched')),
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/git')
        );

        $vcs = new GitVcs($commandExecutor);

        $vcs->changeBranch('feat-new-awesome');

        $this->assertEquals(
            array(
                array(
                    'for-each-ref',
                    'refs/heads/',
                    '--format="%(refname:short)"'
                ),
                array(
                    'checkout',
                    'feat-new-awesome'
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
                file_get_contents(realpath(__DIR__ . '/data/git_branch')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/git_branch_switched')),
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/git')
        );

        $vcs = new GitVcs($commandExecutor);

        $vcs->changeBranch('feat-new-badness');
    }
}
