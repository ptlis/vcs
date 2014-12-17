<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\BranchInterface;

/**
 * Git implementation of shared branch interface.
 */
class Branch implements BranchInterface
{
    /** @var string */
    private $branchDir;

    /** @var string */
    private $name;


    /**
     * @param string $branchDir
     * @param string $name
     */
    public function __construct($branchDir, $name)
    {
        $this->name = $name;
        $this->branchDir = $branchDir;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
