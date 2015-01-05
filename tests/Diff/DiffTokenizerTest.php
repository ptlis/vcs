<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Diff;

use ptlis\Vcs\Diff\Parse\Token;
use ptlis\Vcs\Diff\Parse\UnifiedDiffTokenizer;
use ptlis\Vcs\Git\DiffNormalizer as GitDiffNormalizer;

class DiffTokenizerTest extends \PHPUnit_Framework_TestCase
{
    public function testFirstFile()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::FILE_START, 'README.md'), $tokenList[0]);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 3), $tokenList[1]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 7), $tokenList[2]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 3), $tokenList[3]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 7), $tokenList[4]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, 'A simple VCS wrapper for PHP attempting to offer a consistent API across VCS tools.'), $tokenList[5]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[6]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[7]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, '[![Build Status](https://travis-ci.org/ptlis/conneg.png?branch=master)](https://travis-ci.org/ptlis/vcs) [![Code Coverage](https://scrutinizer-ci.com/g/ptlis/vcs/badges/coverage.png?s=6c30a32e78672ae0d7cff3ecf00ceba95049879a)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ptlis/vcs/badges/quality-score.png?s=b8a262b33dd4a5de02d6f92f3e318ebb319f96c0)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Latest Stable Version](https://poser.pugx.org/ptlis/vcs/v/stable.png)](https://packagist.org/packages/ptlis/vcs)'), $tokenList[8]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '[![Build Status](https://travis-ci.org/ptlis/vcs.png?branch=master)](https://travis-ci.org/ptlis/vcs) [![Code Coverage](https://scrutinizer-ci.com/g/ptlis/vcs/badges/coverage.png?s=6c30a32e78672ae0d7cff3ecf00ceba95049879a)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ptlis/vcs/badges/quality-score.png?s=b8a262b33dd4a5de02d6f92f3e318ebb319f96c0)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Latest Stable Version](https://poser.pugx.org/ptlis/vcs/v/stable.png)](https://packagist.org/packages/ptlis/vcs)'), $tokenList[9]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[10]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[11]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '## Cautions'), $tokenList[12]);
    }

    public function testSecondFile()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::FILE_START, 'build/phpmd.xml'), $tokenList[13]);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 1), $tokenList[14]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 5), $tokenList[15]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 1), $tokenList[16]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 5), $tokenList[17]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '<?xml version="1.0"?>'), $tokenList[18]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, '<ruleset name="ConNeg"'), $tokenList[19]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '<ruleset name="VCS"'), $tokenList[20]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '         xmlns="http://pmd.sf.net/ruleset/1.0.0"'), $tokenList[21]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'), $tokenList[22]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '         xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0 http://pmd.sf.net/ruleset_xml_schema.xsd"'), $tokenList[23]);
    }

    public function testThirdFileFirstChunk()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::FILE_START, 'src/Svn/SvnVcs.php'), $tokenList[24]);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 40), $tokenList[25]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 8), $tokenList[26]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 40), $tokenList[27]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 11), $tokenList[28]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '     * @param RepositoryConfig $repoConfig'), $tokenList[29]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '     * @param string $currentBranch'), $tokenList[30]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '     */'), $tokenList[31]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, '    public function __construct(CommandExecutorInterface $executor, RepositoryConfig $repoConfig, $currentBranch = \'trunk\')'), $tokenList[32]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, '    {'), $tokenList[33]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '    public function __construct('), $tokenList[34]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '        CommandExecutorInterface $executor,'), $tokenList[35]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '        RepositoryConfig $repoConfig,'), $tokenList[36]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '        $currentBranch = \'trunk\''), $tokenList[37]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '    ) {'), $tokenList[38]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $this->executor = $executor;'), $tokenList[39]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $this->repoConfig = $repoConfig;'), $tokenList[40]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $this->currentBranch = $currentBranch;'), $tokenList[41]);
    }

    public function testThirdFileSecondChunk()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 65), $tokenList[42]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 7), $tokenList[43]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 68), $tokenList[44]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 7), $tokenList[45]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '     */'), $tokenList[46]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    public function changeBranch($branch)'), $tokenList[47]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    {'), $tokenList[48]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, '        if (!$this->meta->branchExists((string)$branch)) {'), $tokenList[49]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, '        if (!$this->meta->branchExists((string)$branch) && $this->repoConfig->getTrunkName() !== $branch) {'), $tokenList[50]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '            throw new \RuntimeException(\'Branch named "\' . $branch . \'" not found.\');'), $tokenList[51]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        }'), $tokenList[52]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[53]);
    }

    public function testFourthFile()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::FILE_START, 'tests/RepositoryConfigTest.php'), $tokenList[54]);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 10), $tokenList[55]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 7), $tokenList[56]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 10), $tokenList[57]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 6), $tokenList[58]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[59]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, 'namespace ptlis\Vcs\Test;'), $tokenList[60]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[61]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, ''), $tokenList[62]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, 'use ptlis\Vcs\Svn\RepositoryConfig;'), $tokenList[63]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[64]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, 'class RepositoryConfigTest extends \PHPUnit_Framework_TestCase'), $tokenList[65]);
    }

    public function testFifthFileFirstChunk()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::FILE_START, 'tests/Vcs/Git/ChangeBranchTest.php'), $tokenList[66]);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 48), $tokenList[67]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 6), $tokenList[68]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 48), $tokenList[69]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 7), $tokenList[70]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '            $commandExecutor->getArguments()'), $tokenList[71]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        );'), $tokenList[72]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    }'), $tokenList[73]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_ADDED, ''), $tokenList[74]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    public function testBranchDoesntExist()'), $tokenList[75]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    {'), $tokenList[76]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $this->setExpectedException('), $tokenList[77]);
    }

    public function testFifthFileSecondChunk()
    {
        $tokenizer = new UnifiedDiffTokenizer(new GitDiffNormalizer());

        $data = file(__DIR__ . '/data/git_diff', FILE_IGNORE_NEW_LINES);

        $tokenList = $tokenizer->tokenize($data);

        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_START, 68), $tokenList[78]);
        $this->assertEquals(new Token(Token::HUNK_ORIGINAL_COUNT, 7), $tokenList[79]);
        $this->assertEquals(new Token(Token::HUNK_NEW_START, 69), $tokenList[80]);
        $this->assertEquals(new Token(Token::HUNK_NEW_COUNT, 5), $tokenList[81]);

        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $vcs = new GitVcs($commandExecutor);'), $tokenList[82]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, ''), $tokenList[83]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '        $vcs->changeBranch(\'feat-new-badness\');'), $tokenList[84]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, ''), $tokenList[85]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_REMOVED, ''), $tokenList[86]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '    }'), $tokenList[87]);
        $this->assertEquals(new Token(Token::SOURCE_LINE_UNCHANGED, '}'), $tokenList[88]);
    }
}
