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
use ptlis\Vcs\Shared\Branch;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllBranchesTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $result = array(
            new ShellResult(
                0,
                'master' . PHP_EOL . 'gh-pages' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $meta->getAllBranches();

        $this->assertEquals(
            array(
                array(
                    'for-each-ref',
                    'refs/heads/',
                    '--format="%(refname:short)"'
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $result = array(
            new ShellResult(
                0,
                'master' . PHP_EOL . 'gh-pages' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $actualBranchList = $meta->getAllBranches();

        $this->assertEquals(
            array(
                new Branch('master'),
                new Branch('gh-pages')
            ),
            $actualBranchList
        );
    }
}
