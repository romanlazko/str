# Str - PHP String Utilities

A comprehensive string manipulation library for PHP with multibyte support.

## Installation

```bash
composer require romanlazko/str
```

## Usage

### Using the Str Class

```php
use RomanLazko\Str\Str;

// Get string length
$length = Str::length('Hello World'); // 11

// Convert to kebab-case
$kebab = Str::kebab('fooBar'); // 'foo-bar'

// Convert to snake_case
$snake = Str::snake('fooBar'); // 'foo_bar'
// Convert to camelCase
$camel = Str::camel('foo-bar'); // 'fooBar'
// Convert to StudlyCase
$studly = Str::studly('foo_bar'); // 'FooBar'

// String manipulation
$reversed = Str::reverse('Hello'); // 'olleH'
$limited = Str::limit('This is a long string', 10); // 'This is a...'
$words = Str::words('This is a long string', 3); // 'This is a...'
```

### Using the str() Helper

```php
// Chainable string manipulation
$result = str('Hello World')
    ->upper()
    ->replace('WORLD', 'Universe')
    ->finish('!')
    ->toString();
// Result: 'HELLO UNIVERSE!'
```

## Available Methods

### String Case Conversion
- `camel(string $string): string` - Convert to camelCase
- `kebab(string $string): string` - Convert to kebab-case
- `snake(string $string, string $delimiter = '_'): string` - Convert to snake_case
- `studly(string $string): string` - Convert to StudlyCase
- `title(string $string): string` - Convert to Title Case
- `ucfirst(string $string): string` - Make first character uppercase
- `lcfirst(string $string): string` - Make first character lowercase
- `upper(string $string): string` - Convert to uppercase
- `lower(string $string): string` - Convert to lowercase

### String Manipulation
- `length(string $string, ?string $encoding = 'UTF-8'): int` - Get string length
- `limit(string $string, int $limit = 100, string $end = '...'): string` - Limit string length
- `words(string $string, int $words = 100, string $end = '...'): string` - Limit number of words
- `reverse(string $string): string` - Reverse the string
- `replace(string $string, string|array $search, string|array $replace, int $count = null): string` - Replace text
- `repeat(string $string, int $times): string` - Repeat string
- `slug(string $string, string $separator = '-'): string` - Generate URL-friendly slug
- `substr(string $string, int $start, ?int $length = null, string $encoding = 'UTF-8'): string` - Get substring
- `substrCount(string $string, string $needle): int` - Count substring occurrences
- `substrReplace(string $string, string $replace, int $offset = 0, ?int $length = null): string` - Replace text within portion of string
- `trim(string $string, string $charlist = " \t\n\r\v\0"): string` - Strip whitespace from beginning and end
- `ltrim(string $string, string $charlist = " \t\n\r\v\0"): string` - Strip whitespace from beginning
- `rtrim(string $string, string $charlist = " \t\n\r\v\0"): string` - Strip whitespace from end
- `start(string $string, string $cap): string` - Add string to start if not present
- `finish(string $string, string $cap): string` - Add string to end if not present

### String Checks
- `contains(string $string, string $needle): bool` - Check if string contains substring
- `is(string $pattern, string $value): bool` - Check if string matches pattern
- `startsWith(string $string, string $needle): bool` - Check if string starts with substring
- `endsWith(string $string, string $needle): bool` - Check if string ends with substring
- `isAscii(string $string): bool` - Check if string is ASCII
- `isUuid(string $string): bool` - Check if string is a valid UUID

### Helper Methods
- `str($string = null)` - Create a chainable string instance
  ```php
  $result = str('hello')->upper()->finish('!'); // 'HELLO!'
  ```

## License

This package is open-source software licensed under the [MIT license](LICENSE).

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.