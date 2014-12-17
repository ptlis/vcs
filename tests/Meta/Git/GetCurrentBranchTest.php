<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\Vcs\Git\Branch;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetCurrentBranch extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $branch = 'master';
        $mockExecutor = new MockCommandExecutor(array($branch));

        $meta = new Meta($mockExecutor);
        $meta->getCurrentBranch();

        $this->assertEquals(
            array(
                'rev-parse',
                '--abbrev-ref',
                'HEAD',
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $branch = 'master';
        $mockExecutor = new MockCommandExecutor(array($branch));

        $meta = new Meta($mockExecutor);
        $actualBranch = $meta->getCurrentBranch();

        $this->assertEquals(
            new Branch($branch),
            $actualBranch
        );
        $this->assertEquals($branch, $actualBranch->getName());
        $this->assertEquals($branch, $actualBranch);
    }
}
