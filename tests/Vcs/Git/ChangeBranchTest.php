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

class ChangeBranchTest extends \PHPUnit_Framework_TestCase
{
    public function testBranchExists()
    {
        $commandExecutor = new MockCommandExecutor(array(
            array(
                '* master',
                '  feat-new-awesome'
            ),
            array(
                'Switched to branch \'feat-new-awesome\'',
                'Your branch is behind \'origin/feat-new-awesome\' by 51 commits, and can be fast-forwarded.',
                '(use "git pull" to update your local branch)'
            )
        ));

        $vcs = new GitVcs($commandExecutor);

        $vcs->changeBranch('feat-new-awesome');

        $this->assertEquals(
            array(
                array(
                    'for-each-ref',
                    'refs/heads/',
                    '--format="%(refname:short)"'
                ),
                array(
                    'checkout',
                    'feat-new-awesome'
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
                '* master',
                '  feat-new-awesome'
            ),
            array(

            )
        ));

        $vcs = new GitVcs($commandExecutor);

        $vcs->changeBranch('feat-new-badness');
    }
}
