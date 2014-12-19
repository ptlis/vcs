<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Git;

use ptlis\Vcs\Git\GitVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $commandExecutor = new MockCommandExecutor(array(
            array(),
            array(),
            array(),
            array()
        ));

        $vcs = new GitVcs($commandExecutor);

        $vcs->update();

        $this->assertEquals(
            array(
                array(
                    'stash'
                ),
                array(
                    'fetch'
                ),
                array(
                    'rebase'
                ),
                array(
                    'stash',
                    'pop'
                )
            ),
            $commandExecutor->getArguments()
        );
    }
}
