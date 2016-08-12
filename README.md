# PHP String Builder

[![Build Status](https://travis-ci.org/markenwerk/php-string-builder.svg?branch=master)](https://travis-ci.org/markenwerk/php-string-builder)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-string-builder/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-string-builder/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/57aa33adf27cc20050102f0e/badge.svg)](https://www.versioneye.com/user/projects/57aa33adf27cc20050102f0e)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/ec36917d-baa1-482c-8916-41e2a2c48d5c.svg)](https://insight.sensiolabs.com/projects/ec36917d-baa1-482c-8916-41e2a2c48d5c)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-string-builder/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-string-builder)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/string-builder/v/stable)](https://packagist.org/packages/markenwerk/string-builder)
[![Total Downloads](https://poser.pugx.org/markenwerk/string-builder/downloads)](https://packagist.org/packages/markenwerk/string-builder)
[![License](https://poser.pugx.org/markenwerk/string-builder/license)](https://packagist.org/packages/markenwerk/string-builder)

A basic string builder library providing different string methods written in PHP.

## Installation

```{json}
{
   	"require": {
        "markenwerk/string-builder": "~1.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

### Building and modifying a string

```{php}
use Markenwerk\StringBuilder\StringBuilder;

$builder = new StringBuilder('rolod muspi meroL');
$builder
	->reverse()
	->append(' sit amet, consetetur')
	->append(12)
	->append(false)
	->prepend('b')
	->append(true)
	->insert(1, 'qäs')
	->replace(6, 2, 'wertz')
	->setCharAt(4, '2')
	->delete(0, 2)
	->delete(40)
	->deleteCharAt(3);

$result = $builder->build();
fwrite(STDOUT, ' 1. Built string                                          ' . $result . PHP_EOL);

$result = $builder->buildSubstring(5, 2);
fwrite(STDOUT, ' 2. Built substring                                       ' . $result . PHP_EOL);

$result = $builder->buildSubstring(5);
fwrite(STDOUT, ' 3. Built substring                                       ' . $result . PHP_EOL);

$result = $builder->charAt(5);
fwrite(STDOUT, ' 4. Character                                             ' . $result . PHP_EOL);
```

will output the following

```{txt}
 1. Built string                                          ä2wertzem ipsum dolor sit amet, conset
 2. Built substring                                       rt
 3. Built substring                                       rtzem ipsum dolor sit amet, conset
 4. Character                                             r
```

### Getting string properties

```{php}
$result = $builder->length();
fwrite(STDOUT, ' 5. String length                                         ' . $result . PHP_EOL);

$result = $builder->size();
fwrite(STDOUT, ' 6. Number of bytes                                       ' . $result . PHP_EOL);

$result = $builder->indexOf('e');
fwrite(STDOUT, ' 7. First occurence of "e"                                ' . $result . PHP_EOL);

$result = $builder->indexOf('e', 5);
fwrite(STDOUT, ' 8. First occurence of "e" after position 5               ' . $result . PHP_EOL);

$result = $builder->lastIndexOf('e');
fwrite(STDOUT, ' 9. Last occurence of "e"                                 ' . $result . PHP_EOL);

$result = $builder->lastIndexOf('e', 5);
fwrite(STDOUT, '10. Last occurence of "e" before the 5th last character   ' . $result . PHP_EOL);

$result = $builder->contains('ipsum');
fwrite(STDOUT, '12. Whether the string contains "ipsum"                   ' . $result . PHP_EOL);
```

will output the following

```{txt}
 5. String length                                         38
 6. Number of bytes                                       39
 7. First occurence of "e"                                4
 8. First occurence of "e" after position 5               8
 9. Last occurence of "e"                                 37
10. Last occurence of "e" before the 5th last character   29
12. Whether the string contains "ipsum"                   1
```

### Exception handling

All methods throw an `\InvalidArgumentException` if misconfigured except `indexOf` and `lastIndexOf` wich returns `null` if the given subtring is not contained by the string to build.

```{php}
use Markenwerk\StringBuilder\StringBuilder;

try {
	$builder = new StringBuilder();

	$result = $builder->indexOf('a');
	fwrite(STDOUT, '1. Result                 ' . $result . PHP_EOL);

	$result = $builder->lastIndexOf('a');
	fwrite(STDOUT, '2. Result                 ' . $result . PHP_EOL);

	$result = $builder->charAt(10);
	fwrite(STDOUT, '3. Result                 ' . $result . PHP_EOL);

} catch (\InvalidArgumentException $exception) {
	fwrite(STDERR, 'Exception with message    ' . $exception->getMessage() . PHP_EOL);
}
```

will output the following

```{txt}
1. Result                 <NULL>
2. Result                 <NULL>
Exception with message    Position invalid
```

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-string-builder/blob/master/CONTRIBUTING.md) document.**

## License

PHP String Builder is under the MIT license.
