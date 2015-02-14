<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Shared;

use ptlis\ShellCommand\Interfaces\CommandBuilderInterface;
use ptlis\Vcs\Interfaces\CommandExecutorInterface;

/**
 * Shared implementation of the command executor.
 */
class CommandExecutor implements CommandExecutorInterface
{
    /**
     * @var CommandBuilderInterface Object that can build commands.
     */
    private $commandBuilder;

    /**
     * @var string The vcs command to execute.
     */
    private $command;

    /**
     * @var string The path to the local repository.
     */
    private $repositoryPath;


    /**
     * Constructor.
     *
     * @param CommandBuilderInterface $commandBuilder
     * @param string $command
     * @param string $repositoryPath
     */
    public function __construct(CommandBuilderInterface $commandBuilder, $command, $repositoryPath)
    {
        $this->commandBuilder = $commandBuilder;
        $this->command = $command;
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
        $command = $this->commandBuilder
            ->setCommand($this->command)
            ->setCwd($this->repositoryPath)
            ->addArguments($arguments)
            ->buildCommand();

        $result = $command->runSynchronous();

        return $result->getStdOutLines();
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
