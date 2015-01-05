<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\Vcs\Git\Branch;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllBranchesTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $output = array(
            'master',
            'gh-pages'
        );
        $mockExecutor = new MockCommandExecutor(array($output));

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
        $output = array(
            'master',
            'gh-pages'
        );
        $mockExecutor = new MockCommandExecutor(array($output));

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
