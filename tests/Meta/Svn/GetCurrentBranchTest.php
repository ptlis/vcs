<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\Vcs\Svn\Branch;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetCurrentBranch extends \PHPUnit_Framework_TestCase
{
    public function testCorrectOutputTrunk()
    {
        $branch = 'trunk';
        $mockExecutor = new MockCommandExecutor(array($branch));

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualBranch = $meta->getCurrentBranch();

        $this->assertEquals(
            new Branch($branch),
            $actualBranch
        );
        $this->assertEquals($branch, $actualBranch->getName());
        $this->assertEquals($branch, $actualBranch);
    }

    public function testCorrectOutputBranch()
    {
        $branch = 'foo';
        $mockExecutor = new MockCommandExecutor(array($branch));

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
