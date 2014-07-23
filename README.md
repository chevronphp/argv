# chevron.argv

Argv is a class to parse an ARGV style array. It will parse an array for -flags and
-key=value pairs. It supports the following syntax: "-f" "-flag" "-key=value"
"-key value". Using one or more dashes has no effect.

# usage

$argv = new Argv($GLOBALS["argv"]);
$argv = $argv->parse(["value-one", "value-two"], ["flag-one"]);

# installation

Using [composer](http://getcomposer.org/) `"require" : { "henderjon/chevron-argv": "~1.0" }`

# license

See LICENSE.md for the [BSD-3-Clause](http://opensource.org/licenses/BSD-3-Clause) license.

## links

  - The [Packagist archive](https://packagist.org/packages/henderjon/chevron-argv)
  - Reading on [Semantic Versioning](http://semver.org/)
  - Reading on [Composer Versioning](https://getcomposer.org/doc/01-basic-usage.md#package-versions)

### cool kids badges

#### travis

[![Build Status](https://travis-ci.org/henderjon/chevron.argv.svg?branch=master)](https://travis-ci.org/henderjon/chevron.argv)

#### scruitinizer

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/henderjon/chevron.argv/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.argv/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/henderjon/chevron.argv/badges/build.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.argv/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/henderjon/chevron.argv/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/henderjon/chevron.argv/?branch=master)




