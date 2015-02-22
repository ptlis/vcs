<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Svn\Branch;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetCurrentBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectOutputTrunk()
    {
        $result = array(
            new ShellResult(
                0,
                'trunk' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualBranch = $meta->getCurrentBranch();

        $this->assertEquals(
            new Branch('trunk'),
            $actualBranch
        );
        $this->assertEquals('trunk', $actualBranch->getName());
        $this->assertEquals('trunk', $actualBranch);
    }

    public function testCorrectOutputBranch()
    {
        $result = array(
            new ShellResult(
                0,
                'trunk' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/svn')
        );

        $branch = 'trunk';
        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'), $branch);
        $actualBranch = $meta->getCurrentBranch();

        $this->assertEquals(
            new Branch($branch),
            $actualBranch
        );
        $this->assertEquals($branch, $actualBranch->getName());
        $this->assertEquals($branch, $actualBranch);
    }
}
