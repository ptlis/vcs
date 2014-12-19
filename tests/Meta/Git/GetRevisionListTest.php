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

class GetRevisionListTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(array(array()));

        $meta = new Meta($mockExecutor);
        $meta->getRevisions();

        $this->assertEquals(
            array(
                array(
                    'log',
                    '--format=fuller'
                ),
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $output = array(
            'commit 7603010b472d32c4df233244b3c0c0632c728a1d',
            'Author:     ptlis <ptlis@ptlis.net>',
            'AuthorDate: Sun Nov 30 18:14:24 2014 +0000',
            'Commit:     ptlis <ptlis@ptlis.net>',
            'CommitDate: Sun Nov 30 18:14:24 2014 +0000',
            '',
            '    Fix: Docblock type hints.',
            '',
            'commit 3201fb7119a132cc65b368447310c3a64e0b0916',
            'Author:     ptlis <ptlis@ptlis.net>',
            'AuthorDate: Sun Nov 30 18:10:24 2014 +0000',
            'Commit:     ptlis <ptlis@ptlis.net>',
            'CommitDate: Sun Nov 30 18:10:24 2014 +0000',
            '',
            '    Fix: Several code-style & documentation issues.'
        );
        $mockExecutor = new MockCommandExecutor(array($output));

        $expectedLogList = array(
            new RevisionMeta(
                '7603010b472d32c4df233244b3c0c0632c728a1d',
                'ptlis <ptlis@ptlis.net>',
                new \DateTimeImmutable('30-11-2014 18:14:24+0000'),
                'Fix: Docblock type hints.'
            ),
            new RevisionMeta(
                '3201fb7119a132cc65b368447310c3a64e0b0916',
                'ptlis <ptlis@ptlis.net>',
                new \DateTimeImmutable('30-11-2014 18:10:24+0000'),
                'Fix: Several code-style & documentation issues.'
            )
        );

        $meta = new Meta($mockExecutor);
        $logList = $meta->getRevisions();


        $this->assertEquals($expectedLogList, $logList);
    }
}
