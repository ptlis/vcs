<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Diff\Parse\Git;

use ptlis\Vcs\Diff\File;
use ptlis\Vcs\Diff\Hunk;
use ptlis\Vcs\Diff\Line;
use ptlis\Vcs\Diff\Parse\UnifiedDiffParser;
use ptlis\Vcs\Diff\Parse\UnifiedDiffTokenizer;
use ptlis\Vcs\Git\DiffNormalizer as GitDiffNormalizer;

class DiffParserRemoveTest extends \PHPUnit_Framework_TestCase
{
    public function testParseCount()
    {
        $parser = new UnifiedDiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/diff_remove', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);

        $this->assertInstanceOf('ptlis\Vcs\Diff\Changeset', $diff);
        $this->assertEquals(1, count($diff->getChangedFiles()));
    }

    public function testFileRemove()
    {
        $parser = new UnifiedDiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/diff_remove', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);
        $fileList = $diff->getChangedFiles();

        $this->assertEquals(1, count($fileList[0]->getHunks()));

        $file = new File(
            'README.md',
            '',
            File::DELETED,
            array(
                new Hunk(
                    0,
                    1,
                    0,
                    0,
                    array(
                        new Line(0, -1, Line::REMOVED, '# My project')
                    )
                )
            )
        );

        $this->assertEquals($file, $fileList[0]);
    }
}
