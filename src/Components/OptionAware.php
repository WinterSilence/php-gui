<?php

namespace Gui\Components;

use function array_map;use function explode;use function implode;

/**
 * Option Aware.
 */
trait OptionAware
{
    /**
     * Parse an option string received from Lazarus.
     *
     * @param string $options the options string
     *
     * @return array
     */
    private function parseOptionString(string $options): array
    {
        if ($options) {
            return array_map('trim', explode(',', $options));
        }
        return [];
    }

    /**
     * Returns a string with the representation [option1, option2, ...] to be
     * configured by Lazarus.
     *
     * @param array $options the options
     *
     * @return string a string [option1, options2, option3,...]
     */
    private function getOptionString(array $options): string
    {
        $str = implode(', ', $options);
        return "[$str]";
    }
}
