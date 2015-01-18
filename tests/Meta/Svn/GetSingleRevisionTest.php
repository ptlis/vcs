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
use ptlis\Vcs\Shared\RevisionMeta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetSingleRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(
            array(array()),
            realpath(__DIR__ . '/data/svn_log.xml')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig());
        $meta->getRevision('test');

        $this->assertEquals(
            array(
                array('log',
                    '-r',
                    'test',
                    '--xml',
                    '>',
                    realpath(__DIR__ . '/data/svn_log.xml')
                ),
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $mockExecutor = new MockCommandExecutor(
            array(array()),
            realpath(__DIR__ . '/data/svn_log.xml')
        );

        $meta = new Meta($mockExecutor, new RepositoryConfig());
        $actualRevision = $meta->getRevision('1645937');

        $expectedRevision = new RevisionMeta(
            '1645937',
            'brian',
            \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:07:03.507023Z'),
            'Fixed: the problem with the thing.'
        );

        $this->assertEquals($expectedRevision, $actualRevision);

        // Check getters
        $this->assertEquals('1645937', $actualRevision->getIdentifier());
        $this->assertEquals(
            \DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', '2014-12-16T13:07:03.507023Z'),
            $actualRevision->getCreated()
        );
        $this->assertEquals('brian', $actualRevision->getAuthor());
        $this->assertEquals('Fixed: the problem with the thing.', $actualRevision->getMessage());
    }


//    TODO: Implement for SVN
//    public function testCorrectOutputNotFound()
//    {
//        $output = array(
//            'fatal: ambiguous argument \'wrong identifier\': unknown revision or path not in the working tree.',
//            'Use \'--\' to separate paths from revisions, like this:',
//            '\'git <command> [<revision>...] -- [<file>...]\'commit 7603010b472d32c4df233244b3c0c0632c728a1d'
//        );
//        $mockExecutor = new MockCommandExecutor(array($output));
//
//        $expectedRevision = null;
//
//        $meta = new Meta($mockExecutor);
//        $actualRevision = $meta->getRevision('wrong identifier');
//
//        $this->assertEquals($expectedRevision, $actualRevision);
//    }
}
