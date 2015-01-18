<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Shared;

use ptlis\Vcs\Interfaces\MetaInterface;

/**
 * Shared implementation details for implementers of MetaInterface.
 */
abstract class Meta implements MetaInterface
{
    /**
     * Check to see if the given branch name exists in the repository.
     *
     * @param string $branchName
     *
     * @return bool
     */
    public function branchExists($branchName)
    {
        $found = false;
        foreach ($this->getAllBranches() as $branch) {
            if ($branch->getName() == $branchName) {
                $found = true;
                break;
            }
        }

        return $found;
    }
}
