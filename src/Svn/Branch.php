<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
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
    /** @var string The name of the currently selected branch. */
    private $name;


    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the branch name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Serialise to branch name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
