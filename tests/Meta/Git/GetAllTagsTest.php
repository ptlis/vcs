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
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllTagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $result = array(
            new ShellResult(
                0,
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL . 'v1.0.0' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(
            new MockCommandBuilder($result, '/usr/bin/git')
        );

        $meta = new Meta($mockExecutor);
        $meta->getAllTags();

        $this->assertEquals(
            array(
                array(
                    'tag'
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
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL . 'v1.0.0' . PHP_EOL,
                ''
            )
        );
        $mockExecutor = new MockCommandExecutor(new MockCommandBuilder($result, '/usr/bin/git'));

        $meta = new Meta($mockExecutor);
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                'v0.9.0',
                'v0.9.1',
                'v1.0.0'
            ),
            $actualTagList
        );
    }
}
