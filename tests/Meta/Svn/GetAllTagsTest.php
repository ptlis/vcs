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
use ptlis\Vcs\Shared\Tag;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllTagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($this->getMockResultList(), '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $meta->getAllTags();

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'tags',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '547',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '612',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '834',
                    '--xml'
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($this->getMockResultList(), '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                new Tag(
                    'v0.9.0',
                    new RevisionLog(
                        '547',
                        'colm',
                        new \DateTime('2014-01-08T11:45:43.126845Z'),
                        'Generated doc changes'
                    )
                ),
                new Tag(
                    'v0.9.1',
                    new RevisionLog(
                        '612',
                        'wrowe',
                        new \DateTime('2014-05-15T07:36:29.748798Z'),
                        'Fix the FooWidget'
                    )
                ),
                new Tag(
                    'v1.0.0',
                    new RevisionLog(
                        '834',
                        'bob',
                        new \DateTime('2014-10-09T05:58:19.000000Z'),
                        'Rework the BarWidget to be Baz-compliant'
                    )
                )
            ),
            $actualTagList
        );

        $this->assertInstanceOf(
            '\ptlis\Vcs\Shared\RevisionLog',
            $actualTagList[0]->getRevision()
        );

        $this->assertEquals(
            'v0.9.0',
            $actualTagList[0]->getName()
        );
    }

    private function getMockResultList()
    {
        return array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_list_tags.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_revision_547.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_revision_612.xml')),
                ''
            ),
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_log_revision_834.xml')),
                ''
            ),
        );
    }
}
