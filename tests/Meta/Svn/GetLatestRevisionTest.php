<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetLatestRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(
            array(
                file(realpath(__DIR__ . '/data/svn_info_local.xml'), FILE_IGNORE_NEW_LINES),
                file(realpath(__DIR__ . '/data/svn_info_remote.xml'), FILE_IGNORE_NEW_LINES),
                array()
            ),
            array(
                realpath(__DIR__ . '/data/svn_log.xml')
            )
        );

        $meta = new Meta(
            $mockExecutor,
            new RepositoryConfig()
        );
        $meta->getLatestRevision();

        $this->assertEquals(
            array(
                array(
                    'info',
                    '--xml'
                ),
                array(
                    'info',
                    'http://svn.example.com/myproject/branches/1.0',
                    '--xml'
                ),
                array(
                    'log',
                    '-r',
                    '1645938',
                    '--xml',
                    '>',
                    realpath(__DIR__ . '/data/svn_log.xml')
                )
            ),
            $mockExecutor->getArguments()
        );
    }
}
