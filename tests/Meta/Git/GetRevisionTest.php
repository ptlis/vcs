<?php

/**
 * PHP Version 5.3
 *
 * @copyright   (c) 2015 brian ridley
 * @author      brian ridley <ptlis@ptlis.net>
 * @license     http://opensource.org/licenses/MIT MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Shared\RevisionLog;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $builder = new MockCommandBuilder();
        $builder = $builder
            ->setCommand('/usr/bin/git')
            ->addMockResult(
                0,
                file_get_contents(__DIR__ . '/data/git_diff'),
                ''
            );

        $mockExecutor = new MockCommandExecutor(
            $builder
        );

        $meta = new Meta($mockExecutor);
        $revision = $meta->getRevision(
            new RevisionLog(
                'c6dae50913150a272bfe241bb7fb47935eba4bee',
                'ptlis',
                new \DateTime('Sat, 14 Feb 2015 18:43:51 +0000'),
                'Fix: Use stand-alone command package for executing shell commands.'
            )
        );

        $this->assertEquals(
            array(
                array(
                    'format-patch',
                    '-1',
                    '--stdout',
                    'c6dae50913150a272bfe241bb7fb47935eba4bee'
                )
            ),
            $mockExecutor->getArguments()
        );

        $this->assertInstanceOf(
            '\ptlis\Vcs\Shared\Revision',
            $revision
        );

        $this->assertInstanceOf(
            '\ptlis\Vcs\Shared\RevisionLog',
            $revision->getLog()
        );

        $this->assertInstanceOf(
            '\ptlis\DiffParser\Changeset',
            $revision->getChangeset()
        );
    }
}
