# PHP Simple String Builder

[![Build Status](https://travis-ci.org/markenwerk/php-simple-string-builder.svg?branch=master)](https://travis-ci.org/markenwerk/php-simple-string-builder)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-simple-string-builder/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-simple-string-builder/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/578e8a2d88bf880039f7e56f/badge.svg)](https://www.versioneye.com/user/projects/578e8a2d88bf880039f7e56f)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/925a6e2e-e131-4426-826e-2ed9a7f9213d.svg)](https://insight.sensiolabs.com/projects/925a6e2e-e131-4426-826e-2ed9a7f9213d)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-simple-string-builder/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-simple-string-builder)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/simple-string-builder/v/stable)](https://packagist.org/packages/markenwerk/simple-string-builder)
[![Total Downloads](https://poser.pugx.org/markenwerk/simple-string-builder/downloads)](https://packagist.org/packages/markenwerk/simple-string-builder)
[![License](https://poser.pugx.org/markenwerk/simple-string-builder/license)](https://packagist.org/packages/markenwerk/simple-string-builder)

A basic string builder library providing different string methods written in PHP.

## Installation

```{json}
{
   	"require": {
        "markenwerk/simple-string-builder": "~1.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

### Building a string

```{php}
use Markenwerk\SimpleStringBuilder\SimpleStringBuilder;

$builder = new SimpleStringBuilder();
$builder
	->append('a')
	->append(12)
	->append(false)
	->prepend('b')
	->remove(1)
	->replace(0, 'ab')
	->append(true);

$string = $builder->build();
fwrite(STDOUT, 'Result "' . $string . '"' . PHP_EOL);

$substring = $builder->buildSubstring(0, 2);
fwrite(STDOUT, 'Substring result from position 0 and size 2 "' . $substring . '"' . PHP_EOL);

$substring = $builder->buildSubstring(1);
fwrite(STDOUT, 'Substring result from position 1 till the end "' . $substring . '"' . PHP_EOL);

$size = $builder->size();
fwrite(STDOUT, 'Builder holds "' . $size . '" partial strings' . PHP_EOL);

$length = $builder->length();
fwrite(STDOUT, 'Resulting string length is "' . $length . '" characters' . PHP_EOL);
```

will output the following

```{http}
Result "ab121"
Substring result from position 0 and size 2 "ab12"
Substring result from position 1 till the end "121"
Builder holds "4" partial strings
Resulting string length is "5" characters
```

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-simple-string-builder/blob/master/CONTRIBUTING.md) document.**

## License

PHP Simple String Builder is under the MIT license.
