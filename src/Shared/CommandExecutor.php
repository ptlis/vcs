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

abstract class CommandExecutor implements CommandExecutorInterface
{
    /**
     * Create & return a path to a temp file.
     *
     * @return string The file path of the created file.
     */
    public function getTmpFile()
    {
        return tempnam(sys_get_temp_dir(), 'Vcs');
    }
}
