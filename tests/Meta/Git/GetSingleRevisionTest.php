<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetSingleRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor([]);

        $meta = new Meta($mockExecutor);
        $meta->getRevision('test');

        $this->assertEquals(
            array(
                'log',
                '--format=fuller',
                '-1',
                'test'
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $output = [
            'commit 7603010b472d32c4df233244b3c0c0632c728a1d',
            'Author:     ptlis <ptlis@ptlis.net>',
            'AuthorDate: Sun Nov 30 18:14:24 2014 +0000',
            'Commit:     ptlis <ptlis@ptlis.net>',
            'CommitDate: Sun Nov 30 18:14:24 2014 +0000',
            '',
            '    Fix: Docblock type hints.',
            ''
        ];
        $mockExecutor = new MockCommandExecutor($output);

        $expectedRevision = new RevisionMeta(
            '7603010b472d32c4df233244b3c0c0632c728a1d',
            'ptlis <ptlis@ptlis.net>',
            new \DateTimeImmutable('30-11-2014 18:14:24+0000'),
            'Fix: Docblock type hints.'
        );

        $meta = new Meta($mockExecutor);
        $actualRevision = $meta->getRevision('7603010b472d32c4df233244b3c0c0632c728a1d');

        $this->assertEquals($expectedRevision, $actualRevision);
    }

    public function testCorrectOutputNotFound()
    {
        $output = [
            'fatal: ambiguous argument \'wrong identifier\': unknown revision or path not in the working tree.',
            'Use \'--\' to separate paths from revisions, like this:',
            '\'git <command> [<revision>...] -- [<file>...]\'commit 7603010b472d32c4df233244b3c0c0632c728a1d'
        ];
        $mockExecutor = new MockCommandExecutor($output);

        $expectedRevision = null;

        $meta = new Meta($mockExecutor);
        $actualRevision = $meta->getRevision('wrong identifier');

        $this->assertEquals($expectedRevision, $actualRevision);
    }
}
