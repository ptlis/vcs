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
use ptlis\Vcs\Shared\Tag;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllTagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $result = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_list_tags.xml')),
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $meta->getAllTags();

        $this->assertEquals(
            array(
                array(
                    'ls',
                    'tags',
                    '--xml'
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $result = array(
            new ShellResult(
                0,
                file_get_contents(realpath(__DIR__ . '/data/svn_list_tags.xml')),
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/svn')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                new Tag('v0.9.0', '547'),
                new Tag('v0.9.1', '612'),
                new Tag('v1.0.0', '834')
            ),
            $actualTagList
        );
    }
}
