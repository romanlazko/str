<?php

declare(strict_types=1);

namespace RomanLazko\Str;

use RomanLazko\Support\Traits\Macroable;

use function mb_strlen;
use function mb_strpos;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_substr;
use function mb_convert_case;
use function preg_match;
use function preg_quote;
use function preg_replace;
use function str_contains;
use function str_replace;
use function str_repeat;
use function str_starts_with;
use function substr_count;
use function substr_replace;
use function trim;
use function ltrim;
use function rtrim;
use function ucwords;
use function implode;
use function array_reverse;
use function mb_str_split;

class Str
{
    use Macroable;

    public static function length(string $string, ?string $encoding = 'UTF-8'): int
    {
        return mb_strlen($string, $encoding);
    }

    public static function numbers(string $string): string
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    public static function kebab(string $string): string
    {
        return self::snake($string, '-');
    }

    public static function strpos(string $string, string $needle, int $offset = 0, ?string $encoding = 'UTF-8'): int
    {
        return mb_strpos($string, $needle, $offset, $encoding);
    }

    public static function contains(string $string, string $needle): bool
    {
        return str_contains($string, $needle);
    }

    public static function lower(string $string): string
    {
        return mb_strtolower($string);
    }

    public static function repeat(string $string, int $times): string
    {
        return str_repeat($string, $times);
    }

    public static function replace(string $string, string|array $search, string|array $replace, int $count = null): string
    {
        return str_replace($search, $replace, $string, $count);
    }

    public static function reverse(string $string): string
    {
        return implode(array_reverse(mb_str_split($string)));
    }

    public static function slug(string $string, string $separator = '-'): string
    {
        $string = mb_strtolower($string, 'UTF-8');
        $string = html_entity_decode($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $string = preg_replace('/[ &]+/', $separator, $string);
        $quotedSeparator = preg_quote($separator, '/');
        $string = preg_replace('/[^\p{L}\p{N}' . $quotedSeparator . ']/u', '', $string);
        $string = preg_replace('/' . $quotedSeparator . '{2,}/u', $separator, $string);
        return trim($string, $separator);
    }

    public static function snake(string $string, string $delimiter = '_'): string
    {
        $string = preg_replace('/[\s\-]+/u', $delimiter, $string);
        $string = preg_replace('/(\p{Ll})(\p{Lu})/u', '$1' . $delimiter . '$2', $string);
        $string = preg_replace('/(\p{Lu})(\p{Lu}\p{Ll})/u', '$1' . $delimiter . '$2', $string);
        $string = mb_strtolower($string, 'UTF-8');
        $quoted = preg_quote($delimiter, '/');
        $string = preg_replace('/' . $quoted . '{2,}/u', $delimiter, $string);
        return trim($string, $delimiter);
    }

    public static function camel(string $string): string
    {
        $string = str_replace(['-', '_'], ' ', $string);
        $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
        $string = str_replace(' ', '', $string);
        return lcfirst($string);
    }

    public static function studly(string $string): string
    {
        $string = str_replace(['-', '_'], ' ', $string);
        $string = mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
        return str_replace(' ', '', $string);
    }

    public static function substr(string $string, int $start, ?int $length = null, string $encoding = 'UTF-8'): string
    {
        return mb_substr($string, $start, $length, $encoding);
    }

    public static function substrCount(string $string, string $needle): int
    {
        return substr_count($string, $needle);
    }

    public static function substrReplace(string $string, string $replace, int $offset = 0, ?int $length = null): string
    {
        return substr_replace($string, $replace, $offset, $length ?? strlen($string));
    }

    public static function title(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    public static function trim(string $string, string $charlist = " \t\n\r\v\0"): string
    {
        return trim($string, $charlist);
    }

    public static function ltrim(string $string, string $charlist = " \t\n\r\v\0"): string
    {
        return ltrim($string, $charlist);
    }

    public static function rtrim(string $string, string $charlist = " \t\n\r\v\0"): string
    {
        return rtrim($string, $charlist);
    }

    public static function upper(string $string): string
    {
        return mb_strtoupper($string);
    }

    public static function ucwords(string $string): string
    {
        return ucwords($string);
    }

    public static function lcfirst(string $string): string
    {
        return self::lower(self::substr($string, 0, 1)) . self::substr($string, 1);
    }

    public static function ucfirst(string $string): string
    {
        return self::upper(self::substr($string, 0, 1)) . self::substr($string, 1);
    }

    public static function limit(string $string, int $limit = 100, string $end = '...'): string
    {
        return mb_strlen($string) <= $limit ? $string : mb_substr($string, 0, $limit) . $end;
    }

    public static function words(string $string, int $words = 100, string $end = '...'): string
    {
        $pieces = preg_split('/\s+/u', $string);
        if (count($pieces) <= $words) {
            return $string;
        }
        return implode(' ', array_slice($pieces, 0, $words)) . $end;
    }

    public static function start(string $string, string $cap): string
    {
        return str_starts_with($string, $cap) ? $string : $cap . $string;
    }

    public static function finish(string $string, string $cap): string
    {
        return self::endsWith($string, $cap) ? $string : $string . $cap;
    }

    public static function is(string $pattern, string $value): bool
    {
        if ($pattern === $value) return true;
        $pattern = preg_quote($pattern, '#');
        $pattern = str_replace('\\*', '.*', $pattern);
        return (bool) preg_match('#^' . $pattern . '\z#u', $value);
    }

    public static function after(string $subject, string $search): string
    {
        return $search === '' || !str_contains($subject, $search)
            ? $subject
            : mb_substr($subject, mb_strpos($subject, $search) + mb_strlen($search));
    }

    public static function before(string $subject, string $search): string
    {
        return $search === '' || !str_contains($subject, $search)
            ? $subject
            : mb_substr($subject, 0, mb_strpos($subject, $search));
    }

    public static function between(string $subject, string $from, string $to): string
    {
        return self::before(self::after($subject, $from), $to);
    }

    public static function ascii(string $value): string
    {
        $chars = [
            'Á'=>'A','á'=>'a','À'=>'A','à'=>'a','Â'=>'A','â'=>'a','Ä'=>'A','ä'=>'a','Ã'=>'A','ã'=>'a','Å'=>'A','å'=>'a',
            'Ç'=>'C','ç'=>'c','Č'=>'C','č'=>'c','Ć'=>'C','ć'=>'c',
            'É'=>'E','é'=>'e','È'=>'E','è'=>'e','Ê'=>'E','ê'=>'e','Ë'=>'E','ë'=>'e',
            'Í'=>'I','í'=>'i','Ì'=>'I','ì'=>'i','Î'=>'I','î'=>'i','Ï'=>'I','ï'=>'i',
            'Ñ'=>'N','ñ'=>'n',
            'Ó'=>'O','ó'=>'o','Ò'=>'O','ò'=>'o','Ô'=>'O','ô'=>'o','Ö'=>'O','ö'=>'o','Õ'=>'O','õ'=>'o','Ø'=>'O','ø'=>'o',
            'Š'=>'S','š'=>'s',
            'Ú'=>'U','ú'=>'u','Ù'=>'U','ù'=>'u','Û'=>'U','û'=>'u','Ü'=>'U','ü'=>'u',
            'Ý'=>'Y','ý'=>'y','Ÿ'=>'Y','ÿ'=>'y',
            'Ž'=>'Z','ž'=>'z',
            'А'=>'A','а'=>'a','Б'=>'B','б'=>'b','В'=>'V','в'=>'v','Г'=>'G','г'=>'g',
            'Д'=>'D','д'=>'d','Е'=>'E','е'=>'e','Ё'=>'E','ё'=>'e','Ж'=>'Zh','ж'=>'zh',
            'З'=>'Z','з'=>'z','И'=>'I','и'=>'i','Й'=>'I','й'=>'i','К'=>'K','к'=>'k',
            'Л'=>'L','л'=>'l','М'=>'M','м'=>'m','Н'=>'N','н'=>'n','О'=>'O','о'=>'o',
            'П'=>'P','п'=>'p','Р'=>'R','р'=>'r','С'=>'S','с'=>'s','Т'=>'T','т'=>'t',
            'У'=>'U','у'=>'u','Ф'=>'F','ф'=>'f','Х'=>'Kh','х'=>'kh','Ц'=>'Ts','ц'=>'ts',
            'Ч'=>'Ch','ч'=>'ch','Ш'=>'Sh','ш'=>'sh','Щ'=>'Shch','щ'=>'shch','Ъ'=>'','ъ'=>'',
            'Ы'=>'Y','ы'=>'y','Ь'=>'','ь'=>'','Э'=>'E','э'=>'e','Ю'=>'Yu','ю'=>'yu','Я'=>'Ya','я'=>'ya',
        ];

        return strtr($value, $chars);
    }

    public static function headline(string $value): string
    {
        $value = preg_replace('/[^\\p{L}\\p{N}]+/u', ' ', $value);
        $value = mb_strtolower($value, 'UTF-8');
        $words = explode(' ', $value);
        $words = array_map(fn($word) => mb_convert_case($word, MB_CASE_TITLE, 'UTF-8'), $words);

        return trim(implode(' ', $words));
    }

    public static function squish(string $value): string
    {
        $value = trim($value);
        return preg_replace('/\s+/u', ' ', $value);
    }

    public static function containsAll(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if ($needle === '') continue;
            if (mb_strpos($haystack, $needle) === false) {
                return false;
            }
        }
        return true;
    }

    public static function startsWith(string $haystack, $needles): bool
    {
        if (!is_array($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    public static function endsWith(string $haystack, $needles): bool
    {
        if (!is_array($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle === '') continue;

            $length = mb_strlen($needle);
            if ($length > 0 && mb_substr($haystack, -$length) === $needle) {
                return true;
            }
        }

        return false;
    }

    public static function isAscii(string $value): bool
    {
        return !preg_match('/[^\x00-\x7F]/', $value);
    }

    public static function beforeLast(string $subject, string $search): string
    {
        $pos = mb_strrpos($subject, $search);

        if ($pos === false) {
            return $subject;
        }

        return mb_substr($subject, 0, $pos);
    }

    public static function afterLast(string $subject, string $search): string
    {
        $pos = mb_strrpos($subject, $search);

        if ($pos === false) {
            return $subject;
        }

        return mb_substr($subject, $pos + mb_strlen($search));
    }

    public static function betweenFirst(string $subject, string $from, string $to): string
    {
        $start = mb_strpos($subject, $from);
        if ($start === false) return '';

        $start += mb_strlen($from);
        $end = mb_strpos($subject, $to, $start);
        if ($end === false) return '';

        return mb_substr($subject, $start, $end - $start);
    }

    public static function reverseWords(string $value): string
    {
        $words = preg_split('/\s+/u', trim($value));
        $words = array_reverse($words);

        return implode(' ', $words);
    }

    public static function isMatch(string $pattern, string $value): bool
    {
        return preg_match($pattern, $value) === 1;
    }

    public static function match(string $pattern, string $value): ?string
    {
        if (preg_match($pattern, $value, $matches)) {
            return $matches[0];
        }

        return null;
    }

    public static function matchAll(string $pattern, string $value): array
    {
        if (preg_match_all($pattern, $value, $matches)) {
            return $matches[0];
        }

        return [];
    }

    public static function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function random(int $length = 16): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $result = '';
        $max = strlen($pool) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $pool[random_int(0, $max)];
        }

        return $result;
    }
}
