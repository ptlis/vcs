<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\ShellCommand\ShellResult;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetSingleRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArgumentsAndOutput()
    {
        $results = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/git_log')),
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($results, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $actualRevision = $meta->getRevision('7603010b472d32c4df233244b3c0c0632c728a1d');

        $this->assertEquals(
            array(
                array(
                    'log',
                    '--format=fuller',
                    '-1',
                    '7603010b472d32c4df233244b3c0c0632c728a1d'
                ),
            ),
            $mockExecutor->getArguments()
        );

        $this->assertEquals(
            new RevisionMeta(
                '7603010b472d32c4df233244b3c0c0632c728a1d',
                'ptlis <ptlis@ptlis.net>',
                new \DateTime('30-11-2014 18:14:24+0000'),
                'Fix: Docblock type hints.'
            ),
            $actualRevision
        );

        // Check getters
        $this->assertEquals('7603010b472d32c4df233244b3c0c0632c728a1d', $actualRevision->getIdentifier());
        $this->assertEquals(new \DateTime('30-11-2014 18:14:24+0000'), $actualRevision->getCreated());
        $this->assertEquals('ptlis <ptlis@ptlis.net>', $actualRevision->getAuthor());
        $this->assertEquals('Fix: Docblock type hints.', $actualRevision->getMessage());
    }
}
