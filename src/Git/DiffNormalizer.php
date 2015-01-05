<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Git;

use ptlis\Vcs\Diff\DiffNormalizerInterface;

/**
 * Normalize git-specific behaviours when unified diff is generated.
 */
class DiffNormalizer implements DiffNormalizerInterface
{
    /**
     * Accepts a raw file start line from a unified diff & returns a normalized version of the filename.
     *
     * @param string $fileStartLine
     *
     * @return string
     */
    public function getFileName($fileStartLine)
    {
        return substr($fileStartLine, 6);
    }
}
