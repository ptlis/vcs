<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Svn;

use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Svn\SvnVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $commandExecutor = new MockCommandExecutor(array());

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->update();

        $this->assertEquals(
            array(),
            $commandExecutor->getArguments()
        );
    }
}
