<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\BranchInterface;
use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\RevisionMetaInterface;
use ptlis\Vcs\Shared\Meta as SharedMeta;

/**
 * SVN implementation of shared Meta interface.
 */
class Meta extends SharedMeta
{
    /** @var CommandExecutorInterface Object through which vcs commands can be ran. */
    private $executor;

    /** @var RepositoryConfig Configuration for this repository.  */
    private $repoConfig;

    /** @var string The name of the currently selected branch. */
    private $currentBranchName;


    /**
     * Constructor.
     *
     * @todo Rework $currentBranchName - just use an object
     *
     * @param CommandExecutorInterface $executor
     * @param RepositoryConfig $repoConfig
     * @param string $currentBranchName The current branch, passed in by reference so that we don't need to manually
     *     update it on change - this is really awful!
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
        return new Branch($this->currentBranchName);
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
        $branchList[] = new Branch($this->currentBranchName);
        foreach ($branchDirList as $branchDir) {
            $branchList[] = new Branch($branchDir);
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
     * @return RevisionMetaInterface[]
     */
    public function getRevisions()
    {
        $logParser = new LogParser($this->executor);

        return $logParser->getAll();
    }

    /**
     * Get a revision metadata object from it's identifier or null if one does not exist.
     *
     * @param string $identifier
     *
     * @return RevisionMetaInterface|null
     */
    public function getRevision($identifier)
    {
        $logParser = new LogParser($this->executor);

        return $logParser->getSingle($identifier);
    }
}
