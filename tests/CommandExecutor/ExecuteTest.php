<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\CommandExecutor;

use ptlis\Vcs\Shared\CommandExecutor;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        // For this test we just use the first commit of this project
        $executor = new CommandExecutor('/usr/bin/git', '.');

        $output = $executor->execute(array(
            'log',
            '--reverse',
            '--format=fuller'
        ));


        $this->assertEquals(
            'commit 6f1ed5364b1369b618270b2774f6ec86f77fa213',
            $output[0]
        );
    }
}
