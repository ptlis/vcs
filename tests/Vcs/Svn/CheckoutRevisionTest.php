<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Vcs\Svn;

use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Svn\SvnVcs;
use ptlis\Vcs\Test\MockCommandExecutor;

class CheckoutRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccess()
    {
        $commandExecutor = new MockCommandExecutor(
            array(
                array(),
                array()
            ),
            array(
                realpath(__DIR__ . '/data/svn_log.xml')
            )
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->checkoutRevision('1645937');

        $this->assertEquals(
            array(
                array(
                    'log',
                    '-r',
                    '1645937',
                    '--xml',
                    '>',
                    realpath(__DIR__ . '/data/svn_log.xml')
                ),
                array(
                    'update',
                    '-r',
                    '1645937'
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
                array()
            ),
            array(
                realpath(__DIR__ . '/data/svn_log.xml')
            )
        );

        $vcs = new SvnVcs($commandExecutor, new RepositoryConfig());

        $vcs->checkoutRevision('bob');
    }
}
