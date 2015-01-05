<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Shared;

use ptlis\Vcs\Interfaces\RevisionMetaInterface;

/**
 * Shared Revision metadata class.
 */
class RevisionMeta implements RevisionMetaInterface
{
    /** @var string The unique identifier for the revision. */
    private $identifier;

    /** @var string The author who committed the revision. */
    private $author;

    /** @var \DateTime The time that the revision was committed. */
    private $created;

    /** @var string The commit message for the revision. */
    private $message;


    /**
     * Constructor.
     *
     * @param string $identifier
     * @param string $author
     * @param \DateTime $created
     * @param string $message
     */
    public function __construct(
        $identifier,
        $author,
        \DateTime $created,
        $message
    ) {
        $this->identifier = $identifier;
        $this->author = $author;
        $this->created = $created;
        $this->message = $message;
    }

    /**
     * Get the unique identifier for this revision.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the name of the person who made this revision.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get the date & time the revision was created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Return the commit message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
