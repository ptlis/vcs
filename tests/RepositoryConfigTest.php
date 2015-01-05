<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test;

use ptlis\Vcs\Svn\RepositoryConfig;

class RepositoryConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testGetters()
    {
        $repoConfig = new RepositoryConfig();

        $this->assertEquals('trunk', $repoConfig->getTrunkName());
        $this->assertEquals('tags', $repoConfig->getTagRootDir());
        $this->assertEquals('branches', $repoConfig->getBranchRootDir());
    }
}
