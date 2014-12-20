<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Svn;

use ptlis\Vcs\Interfaces\CommandExecutorInterface;
use ptlis\Vcs\Interfaces\RevisionMetaInterface;
use ptlis\Vcs\Shared\Exception\VcsErrorException;
use ptlis\Vcs\Shared\RevisionMeta;

/**
 * Simple parser for svn log.
 */
class LogParser
{
    /** @var CommandExecutorInterface */
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
     * @return RevisionMetaInterface[]
     */
    public function getAll()
    {
        $tmpFile = $this->executor->getTmpFile();

        $this->executor->execute(array(
            'log',
            '--xml',
            '>',
            $tmpFile
        ));

        $logData = simplexml_load_file($tmpFile);

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
     *
     * @return RevisionMetaInterface[]
     */
    public function getSingle($identifier)
    {
        $tmpFile = $this->executor->getTmpFile();

        $this->executor->execute(array(
            'log',
            '-r',
            $identifier,
            '--xml',
            '>',
            $tmpFile
        ));

        $logData = simplexml_load_file($tmpFile);

        $revisionList = array();
        foreach ($logData->logentry as $logEntry) {
            $revisionList[] = $this->createRevision($logEntry);
        }

        return $revisionList[0];
    }

    /**
     * Create a revisionMeta instance from a single logentry XML element.
     *
     * @param \SimpleXMLElement $logEntry
     *
     * @return RevisionMetaInterface
     */
    private function createRevision(\SimpleXMLElement $logEntry)
    {
        $created = \DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s.u\Z', (string)$logEntry->date);
        $identifier = (string)$logEntry->attributes()->revision;
        $author = (string)$logEntry->author;
        $message = (string)$logEntry->msg;

        return new RevisionMeta(
            $identifier,
            $author,
            $created,
            $message
        );
    }
}
