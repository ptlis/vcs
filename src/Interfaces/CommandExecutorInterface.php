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
 * Shared interface through which VCS commands are executed.
 */
interface CommandExecutorInterface
{
    /**
     * Execute the command.
     *
     * @param string[] $arguments
     *
     * @return string[]
     */
    public function execute(array $arguments = array());

    /**
     * Returns the path to the repository.
     */
    public function getRepositoryPath();
}
