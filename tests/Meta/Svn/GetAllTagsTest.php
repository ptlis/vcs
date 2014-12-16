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
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllTagsTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $output = array(
            'v0.9.0',
            'v0.9.1',
            'v1.0.0'
        );
        $mockExecutor = new MockCommandExecutor($output);

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $meta->getAllTags();

        $this->assertEquals(
            array(
                'ls',
                'tags'
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $output = array(
            'v0.9.0',
            'v0.9.1',
            'v1.0.0'
        );
        $mockExecutor = new MockCommandExecutor($output);

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualTagList = $meta->getAllTags();

        $this->assertEquals(
            array(
                'v0.9.0',
                'v0.9.1',
                'v1.0.0'
            ),
            $actualTagList
        );
    }
}
