<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Svn;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Svn\SvnVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class CheckoutRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $results = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log.xml')),
                ''
            ),
            new ShellResult(
                0,
                '',
                ''
            )
        );
        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->checkoutRevision('1645937');

        $this->assertEquals(
            array(
                array(
                    'log',
                    '-r',
                    '1645937',
                    '--xml'
                ),
                array(
                    'update',
                    '-r',
                    '1645937'
                )
            ),
            $commandExecutor->getArguments()
        );
    }

    public function testNotFound()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'Revision "400" not found.'
        );

        $results = array(
            new ShellResult(
                0,
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
                . '<log>' . PHP_EOL
                . 'svn: E195012: Unable to find repository location for '
                . '\'http://example.com/repos/myproject/trunk\' in revision 400' . PHP_EOL,
                ''
            )
        );

        $commandExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->checkoutRevision('400');
    }
}
