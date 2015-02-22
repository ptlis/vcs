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

class GetRevisionListTest extends \PHPUnit_Framework_TestCase
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
        $revisionList = $meta->getRevisions();

        $this->assertEquals(
            array(
                array(
                    'log',
                    '--format=fuller'
                ),
            ),
            $mockExecutor->getArguments()
        );

        $this->assertEquals(
            array(
                new RevisionMeta(
                    '7603010b472d32c4df233244b3c0c0632c728a1d',
                    'ptlis <ptlis@ptlis.net>',
                    new \DateTime('30-11-2014 18:14:24+0000'),
                    'Fix: Docblock type hints.'
                ),
                new RevisionMeta(
                    '3201fb7119a132cc65b368447310c3a64e0b0916',
                    'ptlis <ptlis@ptlis.net>',
                    new \DateTime('30-11-2014 18:10:24+0000'),
                    'Fix: Several code-style & documentation issues.'
                )
            ),
            $revisionList
        );
    }
}
