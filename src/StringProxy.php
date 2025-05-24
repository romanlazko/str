<?php
declare(strict_types=1);

namespace RomanLazko\Str;

/**
 * StringProxy provides a fluent interface for string manipulation by proxying method calls to the Str class.
 * 
 * @method self length(?string $encoding = 'UTF-8') Get the length of the string
 * @method self numbers() Remove all non-numeric characters from the string
 * @method self kebab() Convert the string to kebab-case
 * @method self strpos(string $needle, int $offset = 0, ?string $encoding = 'UTF-8') Find the position of the first occurrence of a substring in the string
 * @method self after(string $search) Return the remainder of the string after the first occurrence of the given value
 * @method self afterLast(string $search) Return the remainder of the string after the last occurrence of the given value
 * @method self ascii() Transliterate a UTF-8 value to ASCII
 * @method self before(string $search) Get the portion of the string before the first occurrence of the given value
 * @method self beforeLast(string $search) Get the portion of the string before the last occurrence of the given value
 * @method self between(string $from, string $to) Get the portion of the string between the given values
 * @method self betweenFirst(string $from, string $to) Get the smallest possible portion of the string between the given values
 * @method self camel() Convert the string to camelCase
 * @method self contains(string $needle) Determine if the string contains the given value
 * @method self containsAll(array $needles) Determine if the string contains all the given values
 * @method self endsWith(string|array $needles) Determine if the string ends with the given value(s)
 * @method self headline() Convert the string to space-separated words with each word's first letter capitalized
 * @method self is(string $pattern) Determine if the string matches the given pattern
 * @method self isMatch(string $pattern) Determine if the string matches the given regular expression
 * @method self lcfirst() Make the string's first character lowercase
 * @method self limit(int $limit = 100, string $end = '...') Limit the number of characters in the string
 * @method self lower() Convert the string to lowercase
 * @method self ltrim(string $characters = " \t\n\r\v\0") Trim the left side of the string
 * @method self match(string $pattern) Get the portion of the string that matches the given pattern
 * @method self matchAll(string $pattern) Get all portions of the string that match the given pattern
 * @method self random(int $length = 16) Generate a random string of the specified length
 * @method self replace(string|array $search, string|array $replace, ?int $count = null) Replace the given value in the string
 * @method self reverse() Reverse the string
 * @method self reverseWords() Reverse the order of words in the string
 * @method self rtrim(string $characters = " \t\n\r\v\0") Trim the right side of the string
 * @method self slug(string $separator = '-') Generate a URL-friendly slug from the string
 * @method self snake(string $delimiter = '_') Convert the string to snake_case
 * @method self squish() Remove all extra whitespace from the string
 * @method self start(string $prefix) Begin a string with a single instance of the given value
 * @method self startsWith(string|array $needles) Determine if the string starts with the given value(s)
 * @method self studly() Convert the string to StudlyCase
 * @method self substr(int $start, ?int $length = null, string $encoding = 'UTF-8') Get the portion of the string starting at the given position
 * @method self substrCount(string $needle) Count the number of substring occurrences
 * @method self title() Convert the string to Title Case
 * @method self trim(string $characters = " \t\n\r\v\0") Trim the string of the given characters
 * @method self ucfirst() Make the string's first character uppercase
 * @method self ucwords() Uppercase the first character of each word in the string
 * @method self upper() Convert the string to uppercase
 * @method self uuid() Generate a UUID (version 4)
 * @method self words(int $words = 100, string $end = '...') Limit the number of words in the string
 * 
 * @see \RomanLazko\Str\Str
 */
class StringProxy implements \Stringable
{
    public function __construct(public string $string)
    {
    }

    public function __call($method, $parameters): self
    {
        $this->string = Str::$method($this->string, ...$parameters);

        return $this;
    }

    public function toString(): string
    {
        return $this->string;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}