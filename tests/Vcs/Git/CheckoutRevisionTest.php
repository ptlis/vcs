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

class CheckoutRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $results = array(
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
                '',
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/git')
        );

        $vcs = new GitVcs($mockExecutor);

        $vcs->checkoutRevision('3201fb7119a132cc65b368447310c3a64e0b0916');

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
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testNotFound()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'Revision "bob" not found.'
        );

        $results = array(
            new ShellResult(
                0,
                'fatal: ambiguous argument \'bob\': unknown revision or path not in the working tree.' . PHP_EOL
                . 'Use \'--\' to separate paths from revisions, like this:' . PHP_EOL
                . '\'git <command> [<revision>...] -- [<file>...]\'' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/git')
        );

        $vcs = new GitVcs($mockExecutor);

        $vcs->checkoutRevision('bob');
    }
}
