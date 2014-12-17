<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace ptlis\Vcs\Test;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;

/**
 * Mock used to inspect what commands were executed.
 */
class MockCommandExecutor implements CommandExecutorInterface
{
    /**
     * @var string
     */
    private $mockOutput;

    /**
     * @var string[]
     */
    private $arguments;


    /**
     * @param string[] $mockOutput
     */
    public function __construct(array $mockOutput = array())
    {
        $this->mockOutput = $mockOutput;
    }

    /**
     * Execute the command.
     *
     * @param string[] $arguments
     *
     * @return string
     */
    public function execute(array $arguments = array())
    {
        $this->arguments = $arguments;

        return $this->mockOutput;
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
     * Returns the path to the repository.
     */
    public function getRepositoryPath()
    {
        return '';
    }
}
