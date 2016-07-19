# PHP Simple String Builder

[![Build Status](https://travis-ci.org/markenwerk/php-simple-string-builder.svg?branch=master)](https://travis-ci.org/markenwerk/php-simple-string-builder)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-simple-string-builder/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-simple-string-builder/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/578e8a2d88bf880039f7e56f/badge.svg)](https://www.versioneye.com/user/projects/578e8a2d88bf880039f7e56f)
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

In this first implementation the only provided method is appending strings to the builder.

```{php}
use Markenwerk\SimpleStringBuilder\SimpleStringBuilder;

$builder = new SimpleStringBuilder();
$builder
	->append('a')
	->append(12)
	->append(array('a'))
	->append(false)
	->append(true);

$string = $builder->toString();
fwrite(STDOUT, 'Result "' . $string . '"' . PHP_EOL);
```

will output the following

```{http}
Result "a12Array1"
```

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-simple-string-builder/blob/master/CONTRIBUTING.md) document.**

## License

PHP Simple String Builder is under the MIT license.
