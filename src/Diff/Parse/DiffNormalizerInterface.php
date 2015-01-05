<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\Vcs\Diff\Parse;

/**
 * Interface class used with UnifiedDiffTokenizer to normalize VCS-specific behaviours within unified diffs.
 */
interface DiffNormalizerInterface
{
    /**
     * Accepts a raw file start line from a unified diff & returns a normalized version of the filename.
     *
     * @param string $fileStartLine
     *
     * @return string
     */
    public function getFileName($fileStartLine);
}
