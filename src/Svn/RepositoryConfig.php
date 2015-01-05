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
    /** @var string The name for 'trunk' - definable for cases where non-default naming is used. */
    private $trunkName;

    /** @var string The root directory containing branches - definable for cases where non-default naming is used. */
    private $branchRootDir;

    /** @var string The root directory containing tags - definable for cases where non-default naming is used. */
    private $tagRootDir;


    /**
     * Constructor.
     *
     * @param string $trunkName
     * @param string $branchRootDir
     * @param string $tagRootDir
     */
    public function __construct(
        $trunkName = 'trunk',
        $branchRootDir = 'branches',
        $tagRootDir = 'tags'
    ) {
        $this->trunkName = $trunkName;
        $this->branchRootDir = $branchRootDir;
        $this->tagRootDir = $tagRootDir;
    }

    /**
     * Get the branch root directory.
     *
     * @return string
     */
    public function getBranchRootDir()
    {
        return $this->branchRootDir;
    }

    /**
     * Get the tag root directory.
     *
     * @return string
     */
    public function getTagRootDir()
    {
        return $this->tagRootDir;
    }

    /**
     * Get the 'trunk' name.
     *
     * @return string
     */
    public function getTrunkName()
    {
        return $this->trunkName;
    }
}
