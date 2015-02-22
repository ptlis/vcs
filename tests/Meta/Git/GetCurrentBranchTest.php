<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Git\Branch;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetCurrentBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $result = array(
            new ShellResult(
                0,
                'master' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $meta->getCurrentBranch();

        $this->assertEquals(
            array(
                array(
                    'rev-parse',
                    '--abbrev-ref',
                    'HEAD',
                ),
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $result = array(
            new ShellResult(
                0,
                'master' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $actualBranch = $meta->getCurrentBranch();

        $this->assertEquals(
            new Branch('master'),
            $actualBranch
        );
        $this->assertEquals('master', $actualBranch->getName());
        $this->assertEquals('master', $actualBranch);
    }
}
