<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Git;

use ptlis\Vcs\Git\GitVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetMetaTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $commandExecutor = new MockCommandExecutor(array());

        $vcs = new GitVcs($commandExecutor);

        $meta = $vcs->getMeta();

        $this->assertInstanceOf('\ptlis\Vcs\Interfaces\MetaInterface', $meta);
    }
}
