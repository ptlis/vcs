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
use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\LogEntryInterface;
use ptlis\Vcs\Shared\Meta as SharedMeta;

/**
 * SVN implementation of shared Meta interface.
 */
class Meta extends SharedMeta
{
    /** @var CommandExecutorInterface */
    private $executor;

    /** @var RepositoryConfig */
    private $repoConfig;

    /** @var string */
    private $currentBranchName;


    /**
     * @param CommandExecutorInterface $executor
     * @param RepositoryConfig $repoConfig
     * @param string $currentBranchName The current branch, passed in by reference so that we don't need to manually
     *     update it on change.
     */
    public function __construct(
        CommandExecutorInterface $executor,
        RepositoryConfig $repoConfig,
        &$currentBranchName = 'trunk'
    ) {
        $this->executor = $executor;
        $this->repoConfig = $repoConfig;
        $this->currentBranchName = &$currentBranchName;
    }

    /**
     * Get the current branch.
     *
     * @return BranchInterface
     */
    public function getCurrentBranch()
    {
        if ($this->currentBranchName == $this->repoConfig->getTrunkName()) {
            $branchDir = null;
        } else {
            $branchDir = $this->repoConfig->getBranchRootDir();
        }

        return new Branch($branchDir, $this->currentBranchName);
    }

    /**
     * Get a list of all known branches.
     *
     * @return BranchInterface[]
     */
    public function getAllBranches()
    {
        $branchDirList = $this->executor->execute(array(
            'ls',
            $this->repoConfig->getBranchRootDir()
        ));

        $branchList = array();
        $branchList[] = new Branch(null, $this->currentBranchName);
        foreach ($branchDirList as $branchDir) {
            $branchList[] = new Branch($this->repoConfig->getBranchRootDir(), $branchDir);
        }

        return $branchList;
    }

    /**
     * Get a list of all tags.
     *
     * @todo TagInterface ?
     *
     * @return string[]
     */
    public function getAllTags()
    {
        $output = $this->executor->execute(array(
            'ls',
            $this->repoConfig->getTagRootDir()
        ));

        /** @var \SplFileInfo $tagDir */
        $tagList = array();
        foreach ($output as $tagDir) {
            $tagList[] = $tagDir;
        }

        return $tagList;
    }

    /**
     * Get an array of log entries.
     *
     * @return LogEntryInterface[]
     */
    public function getLogs()
    {
        // TODO: Implement getLogs() method.
        return [];
    }
}
