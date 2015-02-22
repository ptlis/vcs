<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Git;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Git\GitVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class ResetRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $result = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/git_log')),
                ''
            ),
            new ShellResult(
                0,
                'master' . PHP_EOL,
                ''
            ),
            new ShellResult(
                0,
                'Switched to a new branch \'ptlis-vcs-temp\'' . PHP_EOL,
                ''
            ),
            new ShellResult(
                0,
                'On branch master' . PHP_EOL
                . 'Your branch is ahead of \'origin/master\' by 5 commits.' . PHP_EOL
                . '  (use "git push" to publish your local commits)' . PHP_EOL,
                ''
            ),
            new ShellResult(
                0,
                'Deleted branch ptlis-vcs-temp (was 3201fb7)' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $vcs = new GitVcs($mockExecutor);

        $vcs->checkoutRevision('3201fb7119a132cc65b368447310c3a64e0b0916');
        $vcs->resetRevision();

        $this->assertEquals(
            array(
                array(
                    'log',
                    '--format=fuller',
                    '-1',
                    '3201fb7119a132cc65b368447310c3a64e0b0916'
                ),
                array(
                    'rev-parse',
                    '--abbrev-ref',
                    'HEAD'
                ),
                array(
                    'checkout',
                    '-b',
                    'ptlis-vcs-temp',
                    '3201fb7119a132cc65b368447310c3a64e0b0916'
                ),
                array(
                    'checkout',
                    'master'
                ),
                array(
                    'branch',
                    '-d',
                    'ptlis-vcs-temp'
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testNotRequired()
    {
        $result = array(
            new ShellResult(
                0,
                'master' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $vcs = new GitVcs($mockExecutor);

        $vcs->resetRevision();

        $this->assertEquals(
            array(),
            $mockExecutor->getArguments()
        );
    }
}
