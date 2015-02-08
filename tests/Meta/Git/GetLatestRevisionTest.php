<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Test\Meta\Git;

use ptlis\Vcs\Git\Meta;
use ptlis\Vcs\Test\MockCommandExecutor;

class GetLatestRevisionTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectArguments()
    {
        $mockExecutor = new MockCommandExecutor(array(array()));

        $meta = new Meta($mockExecutor);
        $meta->getLatestRevision();

        $this->assertEquals(
            array(
                array(
                    'log',
                    '-n',
                    '1'
                ),
            ),
            $mockExecutor->getArguments()
        );
    }
}
