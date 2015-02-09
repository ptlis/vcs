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

class ResetRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testResetRevision()
    {
        $commandExecutor = new MockCommandExecutor(
            array(
                array(
                    'master'
                ),
                array()
            ),
            array()
        );

        $vcs = new GitVcs($commandExecutor);

        $vcs->resetRevision();

        $this->assertEquals(
            array(
                array(
                    'rev-parse',
                    '--abbrev-ref',
                    'HEAD'
                ),
                array(
                    'checkout',
                    'master'
                )
            ),
            $commandExecutor->getArguments()
        );
    }
}
