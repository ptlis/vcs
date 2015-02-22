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

class ResetRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testResetRevision()
    {
        $results = array(
            new ShellResult(
                0,
                '',
                ''
            ),
            new ShellResult(
                0,
                '',
                ''
            )
        );

        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->resetRevision();

        $this->assertEquals(
            array(
                array(
                    'update'
                )
            ),
            $commandExecutor->getArguments()
        );
    }
}
