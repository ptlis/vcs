<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Shared;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;

/**
 * Shared implementation of the command executor.
 */
class CommandExecutor implements CommandExecutorInterface
{
    /**
     * @var string The path to the vcs binary.
     */
    private $binaryPath;

    /**
     * @var string The path to the local repository.
     */
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

        return (array)$output;  // Only alternative is null and it's nicer to always return an array
    }

    /**
     * Create & return a path to a temp file.
     *
     * @todo Remove this - only used in one place & that's a hack!
     *
     * @return string The file path of the created file.
     */
    public function getTmpFile()
    {
        return tempnam(sys_get_temp_dir(), 'Vcs');
    }
}
