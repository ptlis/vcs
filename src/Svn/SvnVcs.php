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
use ptlis\Vcs\Interfaces\MetaInterface;
use ptlis\Vcs\Interfaces\VcsInterface;

/**
 * Svn implementation of shared VCS interface.
 */
class SvnVcs implements VcsInterface
{
    /** @var CommandExecutor */
    private $executor;

    /** @var RepositoryConfig */
    private $repoConfig;

    /** @var string */
    private $currentBranch;

    /** @var Meta */
    private $meta;


    /**
     * @param CommandExecutor $executor
     * @param RepositoryConfig $repoConfig
     * @param string $currentBranch
     */
    public function __construct(CommandExecutor $executor, RepositoryConfig $repoConfig, $currentBranch = 'trunk')
    {
        $this->executor = $executor;
        $this->repoConfig = $repoConfig;
        $this->currentBranch = $currentBranch;
        $this->meta = new Meta($executor, $repoConfig);
    }

    /**
     * Pull down remote changes & apply to local copy.
     */
    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * Change to the specified branch.
     *
     * @throws \RuntimeException Thrown when the requested branch cannot be found.
     *
     * @param string|BranchInterface $branch
     */
    public function changeBranch($branch)
    {
        if (!$this->meta->branchExists($branch)) {
            throw new \RuntimeException('Branch named "' . $branch . '" not found.');
        }

        $this->currentBranch = $branch;
    }

    /**
     * Get normalised repository metadata.
     *
     * @return MetaInterface
     */
    public function getMeta()
    {
        return $this->meta;
    }
}
