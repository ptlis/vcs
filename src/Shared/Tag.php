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

use ptlis\Vcs\Interfaces\RevisionLogInterface;
use ptlis\Vcs\Interfaces\TagInterface;

/**
 * Value type for tags.
 */
class Tag implements TagInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var RevisionLogInterface
     */
    private $revision;


    /**
     * Constructor.
     *
     * @param string $name
     * @param RevisionLogInterface $revision
     */
    public function __construct($name, RevisionLogInterface $revision)
    {
        $this->name = $name;
        $this->revision = $revision;
    }

    /**
     * Get the tag name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the tagged revision.
     *
     * @return RevisionLogInterface
     */
    public function getRevision()
    {
        return $this->revision;
    }
}
