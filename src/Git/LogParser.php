<?php

/**
 * PHP Version 5.4
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Git;

use ptlis\Vcs\Interfaces\RevisionMetaInterface;
use ptlis\Vcs\Shared\Exception\VcsErrorException;
use ptlis\Vcs\Shared\RevisionMeta;

/**
 * Simple parser for git log with the 'fuller' format.
 */
class LogParser
{
    /** Regex used to grab the commit identifier. */
    const IDENTIFIER_REGEX = '/commit (?<identifier>[0-9a-f]{40})/i';

    /** Regex for grabbing the author. */
    const AUTHOR_REGEX = '/Author: (?<author>.*)/i';

    /** Regex for grabbing the creation date. */
    const CREATED_REGEX = '/AuthorDate: (?<created>.*)/';

    /** Format of dates emitted by `git log --format=fuller` */
    const DATE_FORMAT = 'D M j H:i:s Y O';


    /**
     * Accepts an array of log lines from `git log --format=fuller` and returns an array of LogEntry objects.
     *
     * @throws VcsErrorException On VCS error.
     *
     * @param string[] $logLineList
     *
     * @return RevisionMetaInterface[]
     */
    public function parse(array $logLineList)
    {
        // Git has emitted a fatal error
        if (count($logLineList) && 'fatal:' == substr($logLineList[0], 0, 6)) {
            throw new VcsErrorException($logLineList[0]);
        }

        $bundle = array();
        $bundleList = array();

        foreach ($logLineList as $line) {

            switch (true) {
                case preg_match(self::IDENTIFIER_REGEX, $line, $matches):

                    // We have completed a bundle
                    if (count($bundle)) {
                        $bundleList[] = $bundle;
                    }

                    $bundle = array(
                        'identifier' => $matches['identifier'],
                        'created' => null,
                        'author' => '',
                        'message' => array()
                    );
                    break;

                case preg_match(self::AUTHOR_REGEX, $line, $matches):
                    $bundle['author'] = trim($matches['author']);
                    break;

                case preg_match(self::CREATED_REGEX, $line, $matches):
                    $bundle['created'] = \DateTime::createFromFormat(
                        self::DATE_FORMAT,
                        $matches['created']
                    );
                    break;

                case '    ' == substr($line, 0, 4):
                    $line = trim($line);

                    if (count($bundle['message']) || strlen($line)) {
                        $bundle['message'][] = $line;
                    }
                    break;

                default:
                    // Ignore Commit (etc) details
                    break;
            }
        }

        // We have completed a bundle
        if (count($bundle)) {
            $bundleList[] = $bundle;
        }

        return $this->buildLogEntries($bundleList);
    }

    /**
     * Accepts the prepared bundles and returns an array of LogEntry objects.
     *
     * @param array $bundleList
     *
     * @return RevisionMetaInterface[]
     */
    private function buildLogEntries(array $bundleList)
    {
        $logList = array();
        foreach ($bundleList as $bundle) {
            $logList[] = new RevisionMeta(
                $bundle['identifier'],
                $bundle['author'],
                $bundle['created'],
                implode("\n", $bundle['message'])
            );
        }

        return $logList;
    }
}
