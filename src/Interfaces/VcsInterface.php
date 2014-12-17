<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Interfaces;

/**
 * Common version control system interactions.
 */
interface VcsInterface
{
    /**
     * Pull down remote changes & apply to local copy.
     */
    public function update();

    /**
     * Change to the specified branch.
     *
     * @throws \RuntimeException Thrown when the requested branch cannot be found.
     *
     * @param string|BranchInterface $branch
     */
    public function changeBranch($branch);

    /**
     * Get normalised repository metadata.
     *
     * @return MetaInterface
     */
    public function getMeta();
}
