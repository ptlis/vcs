<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Diff\Parse;

use ptlis\Vcs\Diff\File;
use ptlis\Vcs\Diff\Hunk;
use ptlis\Vcs\Diff\Line;
use ptlis\Vcs\Diff\Parse\DiffParser;
use ptlis\Vcs\Diff\Parse\UnifiedDiffTokenizer;
use ptlis\Vcs\Git\DiffNormalizer as GitDiffNormalizer;

class GitDiffParserAddTest extends \PHPUnit_Framework_TestCase
{
    public function testParseCount()
    {
        $parser = new DiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/git_diff_add', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);

        $this->assertInstanceOf('ptlis\Vcs\Diff\Diff', $diff);
        $this->assertEquals(1, count($diff->getChangedFiles()));
    }

    public function testFileAdd()
    {
        $parser = new DiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/git_diff_add', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);
        $fileList = $diff->getChangedFiles();

        $this->assertEquals(1, count($fileList[0]->getHunks()));

        $file = new File(
            '',
            'README.md',
            File::CREATED,
            array(
                new Hunk(
                    0,
                    0,
                    0,
                    1,
                    array(
                        new Line(-1, 0, Line::ADDED, '## Test')
                    )
                )
            )
        );

        $this->assertEquals($file, $fileList[0]);
    }
}
