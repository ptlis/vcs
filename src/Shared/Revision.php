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

namespace ptlis\Vcs\Shared;

use ptlis\DiffParser\Changeset;
use ptlis\Vcs\Interfaces\RevisionInterface;
use ptlis\Vcs\Interfaces\RevisionLogInterface;

/**
 * Revision metadata & changeset.
 */
class Revision implements RevisionInterface
{
    /**
     * @var RevisionLogInterface
     */
    private $log;

    /**
     * @var Changeset
     */
    private $changeset;


    /**
     * Constructor.
     *
     * @param RevisionLogInterface $log
     * @param Changeset $changeset
     */
    public function __construct(RevisionLogInterface $log, Changeset $changeset)
    {
        $this->log = $log;
        $this->changeset = $changeset;
    }

    /**
     * Get the revision log data.
     *
     * @return RevisionLogInterface
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Get the revision changeset.
     *
     * @return Changeset
     */
    public function getChangeset()
    {
        return $this->changeset;
    }
}
