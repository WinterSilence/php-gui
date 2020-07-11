<?php

namespace Gui\Exception;

use RuntimeException;use Throwable;

/**
 * This is the Exception Class for Components
 *
 * @author Johann SERVOIRE @Johann-S
 */
class ComponentException extends RuntimeException
{
    /**
     * Creates new exception.
     *
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Activated when casting to string
     */
    public function __toString(): string
    {
        return static::class . ": [{$this->code}]: {$this->message}\n";
    }
}
