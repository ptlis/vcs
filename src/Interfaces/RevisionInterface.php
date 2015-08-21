<?php

/**
 * PHP Version 5.3
 *
 * @copyright   (c) 2015 brian ridley
 * @author      brian ridley <ptlis@ptlis.net>
 * @license     http://opensource.org/licenses/MIT MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ptlis\Vcs\Interfaces;

use ptlis\DiffParser\Changeset;

/**
 * Representation of a revision; metadata & changeset.
 */
interface RevisionInterface
{
    /**
     * Get the revision log data.
     *
     * @return RevisionLogInterface
     */
    public function getLog();

    /**
     * Get the revision changeset.
     *
     * @return Changeset
     */
    public function getChangeset();
}
