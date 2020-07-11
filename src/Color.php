<?php

namespace Gui;

use InvalidArgumentException;use function ctype_xdigit;use function hexdec;use function ltrim;use function str_split;use function strlen;

/**
 * This is the Color Class
 * This class is used to manipulate color
 *
 * @author Gabriel Couto @gabrielrcouto
 */
class Color
{
    /**
     * Convert a HTML hex color (#rrggbb) to Lazarus Color (integer)
     *
     * @param string $color
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public static function toLazarus(string $color): int
    {
        $color = ltrim($color, '#');
        if (! ctype_xdigit($color)) {
            throw new InvalidArgumentException('Color must be a hexdec string');
        }
        if (strlen($color) === 3) {
            [$r, $g, $b] = str_split($color);
            $r .= $r;
            $g .= $g;
            $b .= $b;
        } elseif (strlen($color) === 6) {
            [$r, $g, $b] = str_split($color, 2);
        } else {
            throw new InvalidArgumentException('Color must have a valid hexdec color format');
        }
        // Lazarus uses #bbggrr
        return hexdec($b . $g . $r);
    }
}
