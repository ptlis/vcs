<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Svn;

use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Svn\SvnVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class ChangeBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $commandExecutor = new MockCommandExecutor(array(
            array(
                'feat-new-awesome'
            )
        ));

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('feat-new-awesome');

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'branches'
                )
            ),
            $commandExecutor->getArguments()
        );
    }

    public function testTrunk()
    {
        $commandExecutor = new MockCommandExecutor(array(
            array(
                'feat-new-awesome'
            )
        ));

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('trunk');

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'branches'
                )
            ),
            $commandExecutor->getArguments()
        );
    }

    public function testBranchDoesntExist()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'Branch named "feat-new-badness" not found.'
        );

        $commandExecutor = new MockCommandExecutor(array(
            array(
                'feat-new-awesome'
            )
        ));

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->changeBranch('feat-new-badness');
    }
}
