<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\CommandExecutor\Svn;

use ptlis\Vcs\Svn\CommandExecutor;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        // For this test we just use the first commit of this project
        $executor = new CommandExecutor('/usr/bin/svn', '.');

        $output = $executor->execute(array(
            'help'
        ));


        $this->assertEquals(
            'usage: svn <subcommand> [options] [args]',
            $output[0]
        );
    }
}
