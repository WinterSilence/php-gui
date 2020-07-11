<?php

namespace Gui;

use function php_uname;use function strpos;use const DIRECTORY_SEPARATOR;use const PHP_OS;

/**
 * This is the OsDetector Class
 * This class is used to check to current OS
 *
 * @author Gabriel Couto @gabrielrcouto
 */
class OsDetector
{
    /**
     * This method is used to check if the current OS is MacOs
     *
     * @return bool
     */
    public static function isMacOS(): bool
    {
        return false !== strpos(PHP_OS, 'Darwin');
    }

    /**
     * This method is used to check if the current OS is Unix
     *
     * @return bool
     */
    public static function isUnix(): bool
    {
        return '/' === DIRECTORY_SEPARATOR;
    }

    /**
     * This method is used to check if the current OS is FreeBSD
     *
     * @return bool
     */
    public static function isFreeBSD(): bool
    {
        return false !== strpos(PHP_OS, 'FreeBSD');
    }

    /**
     * This method is used to check if the current OS is Windows
     *
     * @return bool
     */
    public static function isWindows(): bool
    {
        return '\\' === DIRECTORY_SEPARATOR;
    }
    
    /**
     * This method return system architecture
     *
     * @return string
     */
    public static function systemArchitecture(): string
    {
        return php_uname('m');
    }
}
