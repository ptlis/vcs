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
 * Interface class that revision metadata classes must implement.
 */
interface RevisionLogInterface
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
     * @return \DateTime
     */
    public function getCreated();

    /**
     * Return the commit message.
     *
     * @return string
     */
    public function getMessage();
}
