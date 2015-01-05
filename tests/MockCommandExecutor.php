<?php

/**
 * PHP Version 5.3
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
     * Incremented by one on each call to execute - used to track arguments & decide what data to return.
     *
     * @var int
     */
    private $position = 0;

    /**
     * @var string[]
     */
    private $mockOutput;

    /**
     * @var string[][]
     */
    private $arguments = array();

    /**
     * @var string A temporary file path.
     */
    private $tmpFile;


    /**
     * Constructor.
     *
     * @param string[] $mockOutput
     * @param string $tmpFile
     */
    public function __construct(array $mockOutput = array(), $tmpFile = '')
    {
        $this->mockOutput = $mockOutput;
        $this->tmpFile = $tmpFile;
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
        $this->arguments[$this->position] = $arguments;

        $output = $this->mockOutput[$this->position];
        $this->position++;

        return $output;
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

    /**
     * Create & return a path to a temp file.
     *
     * @return string The file path of the created file.
     */
    public function getTmpFile()
    {
        return $this->tmpFile;
    }
}
