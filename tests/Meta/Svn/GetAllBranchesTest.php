<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Svn;

use ptlis\Vcs\Svn\Branch;
use ptlis\Vcs\Svn\Meta;
use ptlis\Vcs\Svn\RepositoryConfig;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetAllBranchesTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $output = array(
            'dev-awesome-feat',
            'dev-awful-feat'
        );
        $mockExecutor = new MockCommandExecutor($output);

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $meta->getAllBranches();

        $this->assertEquals(
            array(
                'ls',
                'branches'
            ),
            $mockExecutor->getArguments()
        );
    }

    public function testCorrectOutput()
    {
        $output = array(
            'dev-awesome-feat',
            'dev-awful-feat'
        );
        $mockExecutor = new MockCommandExecutor($output);

        $meta = new Meta($mockExecutor, new RepositoryConfig('trunk', 'branches', 'tags'));
        $actualBranchList = $meta->getAllBranches();

        $this->assertEquals(
            array(
                new Branch(null, 'trunk'),
                new Branch('branches', 'dev-awesome-feat'),
                new Branch('branches', 'dev-awful-feat')
            ),
            $actualBranchList
        );
    }
}
