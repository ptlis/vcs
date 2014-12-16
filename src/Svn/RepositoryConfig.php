<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

/**
 * Simple class storing SVN repository configuration information.
 */
class RepositoryConfig
{
    /** @var string */
    private $trunkName;

    /** @var string */
    private $branchRootDir;

    /** @var string */
    private $tagRootDir;


    /**
     * @param string $trunkName
     * @param string $branchRootDir
     * @param string $tagRootDir
     */
    public function __construct(
        $trunkName,
        $branchRootDir,
        $tagRootDir
    ) {
        $this->trunkName = $trunkName;
        $this->branchRootDir = $branchRootDir;
        $this->tagRootDir = $tagRootDir;
    }

    /**
     * @return string
     */
    public function getBranchRootDir()
    {
        return $this->branchRootDir;
    }

    /**
     * @return string
     */
    public function getTagRootDir()
    {
        return $this->tagRootDir;
    }

    /**
     * @return string
     */
    public function getTrunkName()
    {
        return $this->trunkName;
    }
}
