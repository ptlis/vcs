<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Diff;

use ptlis\Vcs\Diff\Line;

class LineTest extends \PHPUnit_Framework_TestCase
{
    public function testLineUnchanged()
    {
        $line = new Line(
            5,
            6,
            Line::UNCHANGED,
            'bob'
        );

        $this->assertEquals(5, $line->getOriginalLineNo());
        $this->assertEquals(6, $line->getNewLineNo());
        $this->assertEquals(Line::UNCHANGED, $line->getOperation());
        $this->assertEquals('bob', $line->getValue());
        $this->assertEquals(' bob', $line->__toString());
    }

    public function testLineRemoved()
    {
        $line = new Line(
            9,
            Line::LINE_NOT_PRESENT,
            Line::REMOVED,
            'some stuff'
        );

        $this->assertEquals(9, $line->getOriginalLineNo());
        $this->assertEquals(-1, $line->getNewLineNo());
        $this->assertEquals(Line::REMOVED, $line->getOperation());
        $this->assertEquals('some stuff', $line->getValue());
        $this->assertEquals('-some stuff', $line->__toString());
    }

    public function testLineAdded()
    {
        $line = new Line(
            Line::LINE_NOT_PRESENT,
            11,
            Line::ADDED,
            'really good comment'
        );

        $this->assertEquals(-1, $line->getOriginalLineNo());
        $this->assertEquals(11, $line->getNewLineNo());
        $this->assertEquals(Line::ADDED, $line->getOperation());
        $this->assertEquals('really good comment', $line->getValue());
        $this->assertEquals('+really good comment', $line->__toString());
    }
}
