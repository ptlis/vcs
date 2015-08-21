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
use ptlis\ShellCommand\Interfaces\CommandResultInterface;
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
     * @throws \RuntimeException on command error.
     *
     * @param string[] $arguments
     *
     * @return CommandResultInterface
     */
    public function execute(array $arguments = array())
    {
        $command = $this->commandBuilder
            ->setCommand($this->command)
            ->setCwd($this->repositoryPath)
            ->addArguments($arguments)
            ->buildCommand();

        $result = $command->runSynchronous();

        if (0 !== $result->getExitCode()) {
            // TODO: Better exception type?
            throw new \RuntimeException($result->getStdErr(), $result->getExitCode());
        }

        return $result;
    }
}
