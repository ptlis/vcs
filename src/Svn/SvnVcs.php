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
use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\MetaInterface;
use ptlis\Vcs\Interfaces\VcsInterface;

/**
 * Svn implementation of shared VCS interface.
 */
class SvnVcs implements VcsInterface
{
    /**
     * @var CommandExecutorInterface Object implementing CommandExecutorInterface for svn.
     */
    private $executor;

    /**
     * @var RepositoryConfig Configuration for this repository.
     */
    private $repoConfig;

    /**
     * @var string The currently selected branch - handled internally for compatibility with git.
     */
    private $currentBranch;

    /**
     * @var Meta Object that grants access to repository metadata.
     */
    private $meta;


    /**
     * Constructor.
     *
     * @param CommandExecutorInterface $executor
     * @param RepositoryConfig $repoConfig
     * @param string $currentBranch
     */
    public function __construct(
        CommandExecutorInterface $executor,
        RepositoryConfig $repoConfig,
        $currentBranch = 'trunk'
    ) {
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
        if (!$this->meta->branchExists((string)$branch)) {
            throw new \RuntimeException('Branch named "' . $branch . '" not found.');
        }

        $this->currentBranch = (string)$branch;
    }

    /**
     * Checkout the specified revision.
     *
     * @throws \RuntimeException Thrown when the requested revision cannot be found.
     *
     * @param string $identifier
     */
    public function checkoutRevision($identifier)
    {
        $revision = $this->meta->getRevisionLog($identifier);
        if (is_null($revision)) {
            throw new \RuntimeException('Revision "' . $identifier . '" not found.');
        }

        $this->executor->execute(array(
            'update',
            '-r',
            $identifier
        ));
    }

    /**
     * Reset the currently checked-out revision to the latest known.
     *
     * @todo This is not strictly correct - what we really want is for the repository to go back to its previous state.
     */
    public function resetRevision()
    {
        $this->executor->execute(array(
            'update'
        ));
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
