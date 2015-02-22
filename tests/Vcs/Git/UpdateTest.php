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

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $result = array(
            new ShellResult(
                0,
                '',
                ''
            ),
            new ShellResult(
                0,
                '',
                ''
            ),
            new ShellResult(
                0,
                '',
                ''
            ),
            new ShellResult(
                0,
                '',
                ''
            ),
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $vcs = new GitVcs($mockExecutor);

        $vcs->update();

        $this->assertEquals(
            array(
                array(
                    'stash'
                ),
                array(
                    'fetch'
                ),
                array(
                    'rebase'
                ),
                array(
                    'stash',
                    'pop'
                )
            ),
            $mockExecutor->getArguments()
        );
    }
}
