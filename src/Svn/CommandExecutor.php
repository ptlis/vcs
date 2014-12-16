<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;

/**
 * Svn implementation of the command executor interface.
 */
class CommandExecutor implements CommandExecutorInterface
{
    /** @var string */
    private $binaryPath;

    /** @var string */
    private $repositoryPath;


    /**
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

        return $output;
    }

    /**
     * Returns the path to the repository.
     */
    public function getRepositoryPath()
    {
        return $this->repositoryPath;
    }
}
