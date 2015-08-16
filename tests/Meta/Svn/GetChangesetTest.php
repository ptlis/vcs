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

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetChangesetTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $builder = new MockCommandBuilder();
        $builder = $builder
            ->setCommand('/usr/bin/svn')
            ->addMockResult(
                0,
                file_get_contents(__DIR__ . '/data/svn_diff'),
                ''
            );

        $mockExecutor = new MockCommandExecutor(
            $builder
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig());
        $changeset = $meta->getChangeset(
            new RevisionMeta(
                '1695913',
                'mrumph',
                new \DateTime('2015-08-14 14:51:38 +0100'),
                'Clarify RewriteRule example in mod_proxy doc'
            )
        );

        $this->assertEquals(
            array(
                array(
                    'diff',
                    '-c',
                    '1695913'
                )
            ),
            $mockExecutor->getArguments()
        );

        $this->assertInstanceOf(
            '\ptlis\DiffParser\Changeset',
            $changeset
        );
    }
}
