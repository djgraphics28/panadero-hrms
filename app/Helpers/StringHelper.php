<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class StringHelper
{
    /**
     * Convert a string to camel case.
     *
     * @param  string  $string
     * @return string
     */
    public static function toCamelCase(string $string): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string))));
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string  $string
     * @return string
     */
    public static function toSnakeCase(string $string): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

    /**
     * Check if a string is a valid email.
     *
     * @param  string  $string
     * @return bool
     */
    public static function isValidEmail(string $string): bool
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Truncate a string to a specified length.
     *
     * @param  string  $string
     * @param  int  $length
     * @param  string  $end
     * @return string
     */
    public static function truncate(string $string, int $length = 100, string $end = '...'): string
    {
        return strlen($string) > $length ? substr($string, 0, $length) . $end : $string;
    }

     /**
     * Convert a date string from 'd/m/Y' format to 'Y-m-d' format.
     *
     * @param  string  $date
     * @return string|null
     */
    public static function convertDateFormat(string $date): ?string
    {
        // Check if the date is in the expected format and parse it
        $parsedDate = Carbon::createFromFormat('d/m/Y', $date);

        // Return the date in 'Y-m-d' format
        return $parsedDate ? $parsedDate->format('Y-m-d') : null;
    }
}
