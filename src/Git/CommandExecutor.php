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
use ptlis\Vcs\Shared\CommandExecutor as SharedCommandExecutor;

/**
 * Git implementation of the command executor interface.
 */
class CommandExecutor extends SharedCommandExecutor implements CommandExecutorInterface
{
    /** @var string The path to the git binary. */
    private $binaryPath;

    /** @var string The path to the git repository. */
    private $repositoryPath;


    /**
     * Constructor.
     *
     * @param string $binaryPath
     * @param string $repositoryPath
     */
    public function __construct($binaryPath, $repositoryPath)
    {
        $this->binaryPath = $binaryPath;
        $this->repositoryPath = $repositoryPath;
    }

    /**
     * Execute the command.
     *
     * Note: Arguments passed in will not be escaped!
     *
     * @param string[] $arguments
     *
     * @return string[]
     */
    public function execute(array $arguments = array())
    {
        $argumentString = implode(' ', $arguments);

        $cwd = getcwd();
        chdir($this->repositoryPath);
        exec($this->binaryPath . ' ' . $argumentString, $output);
        chdir($cwd);

        return (array)$output;  // Only alternative is null and it's nicer to always return an array
    }

    /**
     * Returns the path to the repository.
     */
    public function getRepositoryPath()
    {
        return $this->repositoryPath;
    }
}
