<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\DiffParser\Changeset;
use ptlis\DiffParser\Parser;
use ptlis\Vcs\Interfaces\BranchInterface;
use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\RevisionInterface;
use ptlis\Vcs\Interfaces\RevisionLogInterface;
use ptlis\Vcs\Interfaces\TagInterface;
use ptlis\Vcs\Shared\Meta as SharedMeta;
use ptlis\Vcs\Shared\Revision;
use ptlis\Vcs\Shared\Tag;

/**
 * SVN implementation of shared Meta interface.
 */
class Meta extends SharedMeta
{
    /**
     * @var CommandExecutorInterface Object through which vcs commands can be ran.
     */
    private $executor;

    /**
     * @var RepositoryConfig Configuration for this repository.
     */
    private $repoConfig;

    /**
     * @var string The name of the currently selected branch.
     */
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
        foreach (array_filter($branchDirList->getStdOutLines(), 'strlen') as $branchDir) {
            $branchList[] = new Branch(trim($branchDir));
        }

        return $branchList;
    }

    /**
     * Get a list of all tags.
     *
     * @return TagInterface[]
     */
    public function getAllTags()
    {
        $output = $this->executor->execute(array(
            'ls',
            $this->repoConfig->getTagRootDir(),
            '--xml'
        ));

        libxml_use_internal_errors(true);
        $tagData = simplexml_load_string($output->getStdOut());

        $tagList = array();
        foreach ($tagData->list->entry as $entry) {
            $commitAttrList = $entry->commit->attributes();

            $tagList[] = new Tag(
                (string)$entry->name,
                $this->getRevisionLog((string)$commitAttrList['revision'])
            );
        }

        return $tagList;
    }

    /**
     * Get an array of log entries.
     *
     * @return RevisionLogInterface[]
     */
    public function getAllRevisionLogs()
    {
        $logParser = new LogParser($this->executor);

        return $logParser->getAll();
    }

    /**
     * Get a revision metadata object from it's identifier or null if one does not exist.
     *
     * @param string $identifier
     *
     * @return RevisionLogInterface|null
     */
    public function getRevisionLog($identifier)
    {
        $logParser = new LogParser($this->executor);

        return $logParser->getSingle($identifier);
    }

    /**
     * Get the metadata for the latest revision.
     *
     * @return RevisionLogInterface|null
     */
    public function getLatestRevision()
    {
        $logParser = new LogParser($this->executor);

        $initialOutput = $this->executor->execute(array(
            'info',
            '--xml'
        ));

        libxml_use_internal_errors(true);
        $initialInfo = simplexml_load_string($initialOutput->getStdOut(), null, LIBXML_NOERROR);

        // TODO: Abstract - move this operation into meta? Remember to worry about difference between git remotes?
        $repositoryUrl = (string)$initialInfo->entry->url;

        $serverOutput = $this->executor->execute(array(
            'info',
            $repositoryUrl,
            '--xml'
        ));

        libxml_use_internal_errors(true);   // TODO: Use pervasively - perhaps set in constructors?
        $serverInfo = simplexml_load_string($serverOutput->getStdOut());
        $identifier = (string)$serverInfo->entry->commit->attributes()->revision;

        $revision = $logParser->getSingle($identifier);

        // Revision was not found locally - try remote
        if (is_null($revision)) {
            $revision = $logParser->getSingle($identifier, (string)$serverInfo->entry->url);
        }

        return $revision;
    }

    /**
     * Get a changeset for the specified revision
     *
     * @param RevisionLogInterface $revisionLog
     *
     * @return RevisionInterface
     */
    public function getRevision(RevisionLogInterface $revisionLog)
    {
        $result = $this->executor->execute(array(
            'diff',
            '-c',
            $revisionLog->getIdentifier()
        ));

        $parser = new Parser();
        $changeset = $parser->parseLines($result->getStdOutLines(), Parser::VCS_SVN);

        return new Revision($revisionLog, $changeset);
    }
}
