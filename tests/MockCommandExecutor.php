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

        return $command->runSynchronous();
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

    /**
     * Create & return a path to a temp file.
     *
     * @todo No longer required - remove!
     *
     * @return string The file path of the created file.
     */
    public function getTmpFile()
    {
        return '';
    }
}
