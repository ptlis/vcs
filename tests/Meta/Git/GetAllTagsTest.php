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
use ptlis\Vcs\Shared\Tag;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllTagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $builder = new MockCommandBuilder();
        $builder = $builder
            ->setCommand('/usr/bin/git')
            ->addMockResult(
                0,
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL . 'v1.0.0' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL, '')
            ->addMockResult(0, '7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL, '')
            ->addMockResult(0, '15b593a8e23513b8464275679b4b59b59e926007' . PHP_EOL, '');


        $mockExecutor = new MockCommandExecutor(
            $builder
        );

        $meta = new Meta($mockExecutor);
        $meta->getAllTags();

        $this->assertEquals(
            array(
                array(
                    'tag'
                ),
                array(
                    'rev-list',
                    '-1',
                    'v0.9.0'
                ),
                array(
                    'rev-list',
                    '-1',
                    'v0.9.1'
                ),
                array(
                    'rev-list',
                    '-1',
                    'v1.0.0'
                )
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $builder = new MockCommandBuilder();
        $builder = $builder
            ->setCommand('/usr/bin/git')
            ->addMockResult(
                0,
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL . 'v1.0.0' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL, '')
            ->addMockResult(0, '7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL, '')
            ->addMockResult(0, '15b593a8e23513b8464275679b4b59b59e926007' . PHP_EOL, '');


        $mockExecutor = new MockCommandExecutor(
            $builder
        );

        $meta = new Meta($mockExecutor);
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                new Tag('v0.9.0', '1838fa95822c8008be03dbd8c4e2c14370018cf1'),
                new Tag('v0.9.1', '7f202db7c7f1302d8ced7fa6fb5307320e016a3f'),
                new Tag('v1.0.0', '15b593a8e23513b8464275679b4b59b59e926007')
            ),
            $actualTagList
        );
    }
}
