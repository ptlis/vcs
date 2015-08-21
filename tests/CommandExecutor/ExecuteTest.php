<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\CommandExecutor;

use ptlis\ShellCommand\ShellCommandBuilder;
use ptlis\ShellCommand\UnixEnvironment;
use ptlis\Vcs\Shared\CommandExecutor;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessfulExecute()
    {
        // For this test we just use the first commit of this project
        $executor = new CommandExecutor(
            new ShellCommandBuilder(new UnixEnvironment()),
            '/usr/bin/git',
            '.'
        );

        $output = $executor->execute(array(
            'log',
            '--reverse',
            '--format=fuller'
        ));


        $logLines = $output->getStdOutLines();
        $this->assertEquals(
            'commit 6f1ed5364b1369b618270b2774f6ec86f77fa213',
            $logLines[0]
        );
    }

    public function testErroredExecute()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'error: pathspec \'asdfasdf\' did not match any file(s) known to git.' . PHP_EOL
        );

        // For this test we just checkout a crazy branch name
        $executor = new CommandExecutor(
            new ShellCommandBuilder(new UnixEnvironment()),
            '/usr/bin/git',
            '.'
        );

        $executor->execute(array(
            'checkout',
            'asdfasdf'
        ));
    }
}
