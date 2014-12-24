# ptlis/vcs

A simple VCS wrapper for PHP attempting to offer a consistent API across VCS tools.


[![Build Status](https://travis-ci.org/ptlis/vcs.png?branch=master)](https://travis-ci.org/ptlis/vcs) [![Code Coverage](https://scrutinizer-ci.com/g/ptlis/vcs/badges/coverage.png?s=6c30a32e78672ae0d7cff3ecf00ceba95049879a)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ptlis/vcs/badges/quality-score.png?s=b8a262b33dd4a5de02d6f92f3e318ebb319f96c0)](https://scrutinizer-ci.com/g/ptlis/vcs/) [![Latest Stable Version](https://poser.pugx.org/ptlis/vcs/v/stable.png)](https://packagist.org/packages/ptlis/vcs)


## Cautions

* None of this is utf-8 safe - there's a bunch of manual string manipulation done in a really unsafe way - investigate feasbility of requiring mbstring (or similar).


## TODO

* Worry about status codes pervasively
* Check for presence of git & svn binaries (try to autodetect?)
* Validate repository paths.
