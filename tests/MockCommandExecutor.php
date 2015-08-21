<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace ptlis\Vcs\Test;

use ptlis\ShellCommand\Interfaces\CommandResultInterface;
use ptlis\ShellCommand\Mock\MockCommandBuilder;
use ptlis\Vcs\Interfaces\CommandExecutorInterface;

/**
 * Mock used to inspect what commands were executed.
 */
class MockCommandExecutor implements CommandExecutorInterface
{
    /**
     * @var MockCommandBuilder
     */
    private $builder;

    /**
     * @var string[][]
     */
    private $arguments = array();


    /**
     * Constructor.
     *
     * @param MockCommandBuilder $builder
     */
    public function __construct(MockCommandBuilder $builder)
    {
        $this->builder = $builder;
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
        $this->arguments[] = $arguments;

        $command = $this->builder
            ->addArguments($arguments)
            ->buildCommand();

        $result = $command->runSynchronous();

        if (0 !== $result->getExitCode()) {
            // TODO: Better exception type?
            throw new \RuntimeException($result->getStdErr(), $result->getExitCode());
        }

        return $result;
    }

    /**
     * Get the array of arguments to execute.
     *
     * @return \string[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}
