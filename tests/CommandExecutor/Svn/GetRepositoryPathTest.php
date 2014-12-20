<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\CommandExecutor\Svn;

use ptlis\Vcs\Svn\CommandExecutor;

class GetRepositoryPathTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRepositoryPath()
    {
        $executor = new CommandExecutor('/usr/bin/svn', '/home/brian/dev/super-secret-project');

        $this->assertEquals(
            '/home/brian/dev/super-secret-project',
            $executor->getRepositoryPath()
        );
    }
}
