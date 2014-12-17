<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Git;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\VcsInterface;

/**
 * Git implementation of shared VCS interface.
 */
class GitVcs implements VcsInterface
{
    /** @var CommandExecutorInterface Object implementing CommandExecutorInterface for git. */
    private $executor;

    /** @var Meta Object that grants access to repository metadata. */
    private $meta;


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
     * @param string|Branch $branch
     */
    public function changeBranch($branch)
    {
        if (!$this->meta->branchExists($branch)) {
            throw new \RuntimeException('Branch named "' . $branch . '" not found.');
        }

        $this->executor->execute(array(
            'checkout',
            $branch
        ));
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
