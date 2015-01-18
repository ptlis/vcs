<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\CommandExecutor\Git;

use ptlis\Vcs\Git\CommandExecutor;

class GetRepositoryPathTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRepositoryPath()
    {
        $executor = new CommandExecutor('/usr/bin/git', '/home/brian/dev/super-secret-project');

        $this->assertEquals(
            '/home/brian/dev/super-secret-project',
            $executor->getRepositoryPath()
        );
    }
}
