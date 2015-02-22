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
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetSingleRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArgumentsAndOutput()
    {
        $results = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_single.xml')),
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig());
        $actualRevision = $meta->getRevision('1645938');

        $this->assertEquals(
            array(
                array('log',
                    '-r',
                    '1645938',
                    '--xml'
                ),
            ),
            $mockExecutor->getArguments()
        );

        $expectedRevision = new RevisionMeta(
            '1645938',
            'brian',
            \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:55:25.549151Z'),
            'Update: move foo out of bar to make way for baz.'
        );

        $this->assertEquals($expectedRevision, $actualRevision);

        // Check getters
        $this->assertEquals(
            $expectedRevision->getIdentifier(),
            $actualRevision->getIdentifier()
        );
        $this->assertEquals(
            $expectedRevision->getCreated(),
            $actualRevision->getCreated()
        );
        $this->assertEquals(
            $expectedRevision->getAuthor(),
            $actualRevision->getAuthor()
        );
        $this->assertEquals(
            $expectedRevision->getMessage(),
            $actualRevision->getMessage()
        );
    }
}
