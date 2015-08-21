<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Git;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\RevisionLogInterface;
use ptlis\Vcs\Interfaces\VcsInterface;
use ptlis\Vcs\Shared\Branch;

/**
 * Git implementation of shared VCS interface.
 */
class GitVcs implements VcsInterface
{
    /**
     * @var CommandExecutorInterface Object implementing CommandExecutorInterface for git.
     */
    private $executor;

    /**
     * @var Meta Object that grants access to repository metadata.
     */
    private $meta;

    /**
     * @var RevisionLogInterface Used when checking out a single revision, stores the previously used branch.
     */
    private $previousBranch;


    /**
     * Constructor
     *
     * @param CommandExecutorInterface $executor
     */
    public function __construct(CommandExecutorInterface $executor)
    {
        $this->executor = $executor;
        $this->meta = new Meta($executor);
    }

    /**
     * Pull down remote changes & apply to local copy.
     *
     * @todo This will only work for read-only access!
     */
    public function update()
    {
        $this->executor->execute(array('reset', '--hard'));
        $this->executor->execute(array('fetch'));
        $this->executor->execute(array('rebase'));
    }

    /**
     * Change to the specified branch.
     *
     * @throws \RuntimeException Thrown when the requested branch cannot be found.
     *
     * @param string|Branch $branch
     */
    public function changeBranch($branch)
    {
        if (!$this->meta->branchExists((string)$branch)) {
            throw new \RuntimeException('Branch named "' . $branch . '" not found.');
        }

        $this->executor->execute(array(
            'checkout',
            $branch
        ));
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

        $this->previousBranch = $this->meta->getCurrentBranch();

        $this->executor->execute(array(
            'checkout',
            '-b',
            'ptlis-vcs-temp',
            $identifier
        ));
    }

    /**
     * Reset the currently checked-out revision to the latest known.
     */
    public function resetRevision()
    {
        if (!is_null($this->previousBranch)) {
            $this->executor->execute(array(
                'checkout',
                (string)$this->previousBranch
            ));

            $this->executor->execute(array(
                'branch',
                '-d',
                'ptlis-vcs-temp',
            ));
        }
    }

    /**
     * Get normalised repository metadata.
     *
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }
}
