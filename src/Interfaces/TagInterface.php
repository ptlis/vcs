<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Interfaces;

/**
 * Value type for tags.
 */
interface TagInterface
{
    /**
     * Get the tag name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the tagged revision.
     *
     * @return string
     */
    public function getRevision();
}
