<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetRevisionListTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(
            array(array()),
            realpath(__DIR__ . '/data/svn_log.xml')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $meta->getRevisions();

        $arguments = $mockExecutor->getArguments();

        $this->assertEquals(
            'log',
            $arguments[0][0]
        );

        $this->assertEquals(
            '--xml',
            $arguments[0][1]
        );

        $this->assertEquals(
            '>',
            $arguments[0][2]
        );
    }

    public function testCorrectOutput()
    {
        $mockExecutor = new MockCommandExecutor(
            array(array()),
            realpath(__DIR__ . '/data/svn_log.xml')
        );

        $expectedLogList = array(
            new RevisionMeta(
                '1645937',
                'brian',
                \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:07:03.507023Z'),
                'Fixed: the problem with the thing.'
            ),
            new RevisionMeta(
                '1645938',
                'brian',
                \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:55:25.549151Z'),
                'Update: move foo out of bar to make way for baz.'
            )
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig());
        $logList = $meta->getRevisions();


        $this->assertEquals($expectedLogList, $logList);
    }
}
