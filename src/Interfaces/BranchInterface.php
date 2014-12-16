<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Interfaces;

/**
 * Interface BranchInterface
 * @package ptlis\Vcs
 */
interface BranchInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function __toString();
}
