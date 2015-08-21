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
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL, '')
            ->addMockResult(
                0,
                'commit 1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL .
                'Author:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 25 18:55:15 2015 +0100' . PHP_EOL .
                'Commit:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 25 18:55:15 2015 +0100' . PHP_EOL .
                '' . PHP_EOL .
                '    Rework the thingy' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL, '')
            ->addMockResult(
                0,
                'commit 7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL .
                'Author:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 31 12:28:03 2015 +0100' . PHP_EOL .
                'Commit:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'CommitDate: Fri Jul 31 12:28:03 2015 +0100' . PHP_EOL .
                '' . PHP_EOL .
                '    Update the FooWidget to 3.1415' . PHP_EOL,
                ''
            );


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

                    'log',
                    '--format=fuller',
                    '-1',
                    '1838fa95822c8008be03dbd8c4e2c14370018cf1'
                ),
                array(
                    'rev-list',
                    '-1',
                    'v0.9.1'
                ),
                array(

                    'log',
                    '--format=fuller',
                    '-1',
                    '7f202db7c7f1302d8ced7fa6fb5307320e016a3f'
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
                'v0.9.0' . PHP_EOL . 'v0.9.1' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL, '')
            ->addMockResult(
                0,
                'commit 1838fa95822c8008be03dbd8c4e2c14370018cf1' . PHP_EOL .
                'Author:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 25 18:55:15 2015 +0100' . PHP_EOL .
                'Commit:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 25 18:55:15 2015 +0100' . PHP_EOL .
                '' . PHP_EOL .
                '    Rework the thingy' . PHP_EOL,
                ''
            )
            ->addMockResult(0, '7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL, '')
            ->addMockResult(
                0,
                'commit 7f202db7c7f1302d8ced7fa6fb5307320e016a3f' . PHP_EOL .
                'Author:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'AuthorDate: Fri Jul 31 12:28:03 2015 +0100' . PHP_EOL .
                'Commit:     ptlis <ptlis@ptlis.net>' . PHP_EOL .
                'CommitDate: Fri Jul 31 12:28:03 2015 +0100' . PHP_EOL .
                '' . PHP_EOL .
                '    Update the FooWidget to 3.1415' . PHP_EOL,
                ''
            );


        $mockExecutor = new MockCommandExecutor(
            $builder
        );

        $meta = new Meta($mockExecutor);
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                new Tag(
                    'v0.9.0',
                    new RevisionMeta(
                        '1838fa95822c8008be03dbd8c4e2c14370018cf1',
                        'ptlis <ptlis@ptlis.net>',
                        new \DateTime('Fri Jul 25 18:55:15 2015 +0100'),
                        'Rework the thingy'
                    )
                ),
                new Tag(
                    'v0.9.1',
                    new RevisionMeta(
                        '7f202db7c7f1302d8ced7fa6fb5307320e016a3f',
                        'ptlis <ptlis@ptlis.net>',
                        new \DateTime('Fri Jul 31 12:28:03 2015 +0100'),
                        'Update the FooWidget to 3.1415'
                    )
                )
            ),
            $actualTagList
        );
    }
}
