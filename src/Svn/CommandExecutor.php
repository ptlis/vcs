<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Shared\CommandExecutor as SharedCommandExecutor;

/**
 * Svn implementation of the command executor interface.
 */
class CommandExecutor extends SharedCommandExecutor implements CommandExecutorInterface
{
    /** @var string The path to the svn binary. */
    private $binaryPath;

    /** @var string The path to the svn repository. */
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

        if (is_null($output)) {
            $output = array();
        }

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
