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
 * Used to retrieve metadata about the current state of the local copy.
 */
interface MetaInterface
{
    /**
     * Get the current branch.
     *
     * @return BranchInterface
     */
    public function getCurrentBranch();

    /**
     * Get a list of all known branches.
     *
     * @return BranchInterface[]
     */
    public function getAllBranches();

    /**
     * Get a list of all tags.
     *
     * @todo TagInterface ?
     *
     * @return string[]
     */
    public function getAllTags();

    /**
     * Check to see if the given branch name exists in the repository.
     *
     * @param string $branchName
     *
     * @return bool
     */
    public function branchExists($branchName);

    /**
     * Get an array of log entries.
     *
     * @return LogEntryInterface[]
     */
    public function getLogs();
}
