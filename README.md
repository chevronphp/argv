# chevron.argv

Argv is a class to parse an ARGV style array. It will parse an array for -flags and
-key=value pairs. It supports the following syntax: "-f" "-flag" "-key=value"
"-key value". Using one or more dashes has no effect.

# usage

$argv = new Argv($GLOBALS["argv"]);
$argv = $argv->parse(["value-one", "value-two"], ["flag-one"]);

# installation

Using [composer](http://getcomposer.org/) `"require" : { "henderjon/chevron-argv": "1.*" }`

# license

See LICENSE.md for the [BSD-3-Clause](http://opensource.org/licenses/BSD-3-Clause) license.

## links

  - The [Packagist archive](https://packagist.org/packages/henderjon/chevron-argv)
  - Reading on [Semantic Versioning](http://semver.org/)
  - Reading on [Composer Versioning](https://getcomposer.org/doc/01-basic-usage.md#package-versions)





