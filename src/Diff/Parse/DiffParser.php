<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Diff\Parse;

use ptlis\Vcs\Diff\Diff;
use ptlis\Vcs\Diff\File;
use ptlis\Vcs\Diff\Hunk;
use ptlis\Vcs\Diff\Line;

/**
 * Class that parses a unified diff into a data-structure for convenient manipulation.
 */
class DiffParser
{
    /**
     * @var UnifiedDiffTokenizer
     */
    private $tokenizer;


    /**
     * Constructor.
     *
     * @param UnifiedDiffTokenizer $tokenizer
     */
    public function __construct(UnifiedDiffTokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    /**
     * Parse an array of tokens out into an object graph.
     *
     * @param array $diffLineList
     *
     * @return Diff
     */
    public function parse(array $diffLineList)
    {
        $tokenList = $this->tokenizer->tokenize($diffLineList);

        $fileList = array();
        $startIndex = 0;
        for ($i = 0; $i < count($tokenList); $i++) {

            // File begin
            if (Token::ORIGINAL_FILENAME === $tokenList[$i]->getType()) {
                $startIndex = $i;
            }

            // File end, hydrate object
            if ($this->fileEnd($tokenList, $i + 1, Token::ORIGINAL_FILENAME)) {
                $fileList[] = $this->parseFile(
                    array_slice($tokenList, $startIndex, ($i - $startIndex) + 1)
                );
            }
        }

        return new Diff($fileList);
    }

    /**
     * Process the tokens for a single file, returning a File instance on success.
     *
     * @param Token[] $fileTokenList
     *
     * @return File
     */
    private function parseFile(array $fileTokenList)
    {
        $originalName = $fileTokenList[0]->getValue();
        $newName = $fileTokenList[1]->getValue();

        $hunkList = array();
        $startIndex = 0;

        for ($i = 2; $i < count($fileTokenList); $i++) {

            // Hunk begin
            if ($this->hunkStart($fileTokenList[$i])) {
                $startIndex = $i;
            }

            // End of file, hydrate object
            if ($i === count($fileTokenList) - 1) {
                $hunkList[] = $this->parseHunk(
                    array_slice($fileTokenList, $startIndex)
                );

            // End of hunk, hydrate object
            } elseif ($this->hunkStart($fileTokenList[$i + 1])) {
                $hunkList[] = $this->parseHunk(
                    array_slice($fileTokenList, $startIndex, $i - $startIndex + 1)
                );
            }
        }

        return new File(
            $originalName,
            $newName,
            $this->getFileOperation($originalName, $newName),
            $hunkList
        );
    }

    /**
     * @param Token[] $hunkTokenList
     *
     * @return Hunk
     */
    private function parseHunk(array $hunkTokenList)
    {
        switch (true) {
            case Token::FILE_DELETION_LINE_COUNT === $hunkTokenList[0]->getType():
                $originalStart = 0;
                $originalCount = intval($hunkTokenList[0]->getValue());
                $newStart = intval($hunkTokenList[1]->getValue());
                $newCount = intval($hunkTokenList[2]->getValue());
                $skipLines = 3;
                break;

            case Token::FILE_CREATION_LINE_COUNT === $hunkTokenList[2]->getType():
                $originalStart = intval($hunkTokenList[0]->getValue());
                $originalCount = intval($hunkTokenList[1]->getValue());
                $newStart = 0;
                $newCount = intval($hunkTokenList[2]->getValue());
                $skipLines = 3;
                break;

            default:
                $originalStart = intval($hunkTokenList[0]->getValue());
                $originalCount = intval($hunkTokenList[1]->getValue());
                $newStart = intval($hunkTokenList[2]->getValue());
                $newCount = intval($hunkTokenList[3]->getValue());
                $skipLines = 4;
                break;
        }

        $originalLineNo = $originalStart;
        $newLineNo = $newStart;
        $lineList = array();
        for ($i = $skipLines; $i < count($hunkTokenList); $i++) {
            $operation = $this->mapLineOperation($hunkTokenList[$i]);

            $lineList[] = new Line(
                (Line::ADDED) === $operation ? Line::LINE_NOT_PRESENT : $originalLineNo,
                (Line::REMOVED) === $operation ? Line::LINE_NOT_PRESENT : $newLineNo,
                $operation,
                $hunkTokenList[$i]->getValue()
            );

            if (Line::ADDED === $operation) {
                $newLineNo++;

            } elseif (Line::REMOVED === $operation) {
                $originalLineNo++;

            } else {
                $originalLineNo++;
                $newLineNo++;
            }
        }

        return new Hunk(
            $originalStart,
            $originalCount,
            $newStart,
            $newCount,
            $lineList
        );
    }

    /**
     * Determine if we're at the end of a 'section' of tokens.
     *
     * @param Token[] $tokenList
     * @param int $nextLine
     * @param string $delimiterToken
     *
     * @return bool
     */
    private function fileEnd(array $tokenList, $nextLine, $delimiterToken)
    {
        return $nextLine == count($tokenList) || $delimiterToken === $tokenList[$nextLine]->getType();
    }

    /**
     * Returns true if the token indicates the start of a hunk.
     *
     * @param Token $token
     *
     * @return bool
     */
    private function hunkStart(Token $token)
    {
        return Token::HUNK_ORIGINAL_START === $token->getType()
            || Token::FILE_DELETION_LINE_COUNT === $token->getType();
    }

    /**
     * Maps between token representation of line operations and the correct const from the Line class.
     *
     * @param Token $token
     *
     * @return string
     */
    private function mapLineOperation(Token $token)
    {
        if (Token::SOURCE_LINE_ADDED === $token->getType()) {
            $operation = Line::ADDED;

        } elseif (Token::SOURCE_LINE_REMOVED === $token->getType()) {
            $operation = Line::REMOVED;

        } else {
            $operation = Line::UNCHANGED;
        }

        return $operation;
    }

    /**
     * Get the operation performed on the file (create, delete, change).
     *
     * @param string $originalName
     * @param string $newName
     *
     * @return string
     */
    private function getFileOperation($originalName, $newName)
    {
        if (!strlen($originalName)) {
            $operation = File::CREATED;

        } elseif (!strlen($newName)) {
            $operation = File::DELETED;

        } else {
            $operation = File::CHANGED;
        }

        return $operation;
    }
}
