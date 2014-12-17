<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */


namespace ptlis\Vcs\Interfaces;

/**
 * Interface class that log entries must implement.
 */
interface LogEntryInterface
{
    /**
     * Get the unique identifier for this commit.
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get the name of the person who made this commit.
     *
     * @return string
     */
    public function getAuthor();

    /**
     * Get the date & time the commit was made.
     *
     * @return \DateTimeImmutable
     */
    public function getCreated();

    /**
     * Return the commit message.
     *
     * @return string
     */
    public function getMessage();
}
