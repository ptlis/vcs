<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Shared;

use ptlis\Vcs\Interfaces\LogEntryInterface;

/**
 * Shared Log Entry class.
 */
class LogEntry implements LogEntryInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @var string
     */
    private $message;


    /**
     * Constructor.
     *
     * @param string $identifier
     * @param string $author
     * @param \DateTimeImmutable $created
     * @param string $message
     */
    public function __construct(
        $identifier,
        $author,
        \DateTimeImmutable $created,
        $message
    ) {
        $this->identifier = $identifier;
        $this->author = $author;
        $this->created = $created;
        $this->message = $message;
    }

    /**
     * Get the unique identifier for this commit.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Get the name of the person who made this commit.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get the date & time the commit was made.
     *
     * @return \DateTimeImmutable
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
