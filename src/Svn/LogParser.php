<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\RevisionLogInterface;
use ptlis\Vcs\Shared\Exception\VcsErrorException;
use ptlis\Vcs\Shared\RevisionLog;

/**
 * Simple parser for svn log.
 */
class LogParser
{
    /**
     * @var CommandExecutorInterface Object through which command can be executed
     */
    private $executor;


    /**
     * Constructor.
     *
     * @param CommandExecutorInterface $executor
     */
    public function __construct(CommandExecutorInterface $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Accepts an array of log lines from `svn log --xml` and returns an array of LogEntry objects.
     *
     * @throws VcsErrorException On VCS error.
     *
     * @return RevisionLogInterface[]
     */
    public function getAll()
    {
        $result = $this->executor->execute(array(
            'log',
            '--xml'
        ));

        libxml_use_internal_errors(true);
        $logData = simplexml_load_string($result->getStdOut());

        $revisionList = array();
        foreach ($logData->logentry as $logEntry) {
            $revisionList[] = $this->createRevision($logEntry);
        }

        return $revisionList;
    }

    /**
     * Accepts an array of log lines from `svn log --xml` and returns an array of LogEntry objects.
     *
     * @throws VcsErrorException On VCS error.
     *
     * @param int $identifier
     * @param string $remoteUrl
     *
     * @return RevisionLogInterface
     */
    public function getSingle($identifier, $remoteUrl = '')
    {
        $arguments = array(
            'log',
            '-r',
            $identifier,
            '--xml'
        );

        if (strlen($remoteUrl)) {
            $arguments[] = $remoteUrl;
        }

        $result = $this->executor->execute($arguments);

        libxml_use_internal_errors(true);
        $logData = simplexml_load_string($result->getStdOut());

        $revision = null;
        if (false !== $logData) {
            foreach ($logData->logentry as $logEntry) {
                $tmpRevision = $this->createRevision($logEntry);

                if ($identifier === $tmpRevision->getIdentifier()) {
                    $revision = $tmpRevision;
                }
            }
        }

        return $revision;
    }

    /**
     * Create a revisionMeta instance from a single logentry XML element.
     *
     * @param \SimpleXMLElement $logEntry
     *
     * @return RevisionLogInterface
     */
    private function createRevision(\SimpleXMLElement $logEntry)
    {
        // Note that the commit date/time is set serverside and is always UTC
        // See http://svn.haxx.se/users/archive-2003-09/0322.shtml
        $created = \DateTime::createFromFormat(
            'Y-m-d\TH:i:s.u\Z',
            (string)$logEntry->date,
            new \DateTimeZone('UTC')
        );
        $identifier = (string)$logEntry->attributes()->revision;
        $author = (string)$logEntry->author;
        $message = (string)$logEntry->msg;

        return new RevisionLog(
            $identifier,
            $author,
            $created,
            $message
        );
    }
}
