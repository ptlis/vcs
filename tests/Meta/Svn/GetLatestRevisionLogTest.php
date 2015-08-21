<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Shared\RevisionLog;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetLatestRevisionLogTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $results = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_info_local.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_info_remote.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_local.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_remote.xml')),
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $meta = new Meta(
            $mockExecutor,
            new RepositoryConfig()
        );
        $revision = $meta->getLatestRevision();

        $this->assertEquals(
            array(
                array(
                    'info',
                    '--xml'
                ),
                array(
                    'info',
                    'http://svn.example.com/myproject/branches/1.0',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '1645938',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '1645938',
                    '--xml',
                    'http://svn.example.com/myproject/branches/1.0'
                )
            ),
            $mockExecutor->getArguments()
        );

        $this->assertEquals(
            new RevisionLog(
                '1645938',
                'brian',
                \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:55:25.549151Z'),
                'Update: move foo out of bar to make way for baz.'
            ),
            $revision
        );
    }
}
