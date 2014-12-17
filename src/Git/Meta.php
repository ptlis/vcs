<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Git;

use ptlis\Vcs\Interfaces\BranchInterface;
use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\LogEntryInterface;
use ptlis\Vcs\Shared\Meta as SharedMeta;

/**
 * Git implementation of shared Meta interface.
 */
class Meta extends SharedMeta
{
    /** @var CommandExecutorInterface Object through which vcs commands can be ran. */
    private $executor;


    /**
     * Constructor.
     *
     * @param CommandExecutorInterface $executor
     */
    public function __construct(CommandExecutorInterface $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Get the current branch.
     *
     * @return BranchInterface
     */
    public function getCurrentBranch()
    {
        $output = $this->executor->execute(array(
            'rev-parse',
            '--abbrev-ref',
            'HEAD'
        ));

        return new Branch($output[0]);
    }

    /**
     * Get a list of all known branches.
     *
     * @return BranchInterface[]
     */
    public function getAllBranches()
    {
        $output = $this->executor->execute(array(
            'for-each-ref',
            'refs/heads/',
            '--format="%(refname:short)"'
        ));

        $branchList = array();
        foreach ($output as $branchName) {
            $branchList[] = new Branch(trim($branchName));
        }

        return $branchList;
    }

    /**
     * Get a list of all tags.
     *
     * @return string[]
     */
    public function getAllTags()
    {
        return $this->executor->execute(array(
            'tag'
        ));
    }

    /**
     * Get an array of log entries.
     *
     * @return LogEntryInterface[]
     */
    public function getLogs()
    {
        $logLineList = $this->executor->execute(array(
            'log',
            '--format=fuller'
        ));

        $logParser = new LogParser();

        return $logParser->parse($logLineList);
    }
}
