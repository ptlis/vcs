<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Git;

use ptlis\Vcs\Git\GitVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class CheckoutRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
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
        $commandExecutor = new MockCommandExecutor(
            array(
                $output,
                array('master'),
                array()
            )
        );

        $vcs = new GitVcs($commandExecutor);

        $vcs->checkoutRevision('3201fb7119a132cc65b368447310c3a64e0b0916');

        $this->assertEquals(
            array(
                array(
                    'log',
                    '--format=fuller',
                    '-1',
                    '3201fb7119a132cc65b368447310c3a64e0b0916'
                ),
                array(
                    'rev-parse',
                    '--abbrev-ref',
                    'HEAD'
                ),
                array(
                    'checkout',
                    '-b',
                    'ptlis-vcs-temp',
                    '3201fb7119a132cc65b368447310c3a64e0b0916'
                )
            ),
            $commandExecutor->getArguments()
        );
    }
    public function testNotFound()
    {
        $this->setExpectedException(
            '\RuntimeException',
            'Revision "bob" not found.'
        );

        $commandExecutor = new MockCommandExecutor(
            array(
                array(),
                array()
            )
        );

        $vcs = new GitVcs($commandExecutor);

        $vcs->checkoutRevision('bob');
    }
}
