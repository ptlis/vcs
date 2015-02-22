<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Interfaces;

use ptlis\ShellCommand\Interfaces\CommandResultInterface;

/**
 * Shared interface through which VCS commands are executed.
 */
interface CommandExecutorInterface
{
    /**
     * Execute the command.
     *
     * @param string[] $arguments
     *
     * @return CommandResultInterface
     */
    public function execute(array $arguments = array());
}
