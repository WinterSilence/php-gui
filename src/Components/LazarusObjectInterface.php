<?php

namespace Gui\Components;

/**
 * This is the LazarusObjectInterface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 */
interface LazarusObjectInterface
{
    /**
     * Gets the value of lazarusObjectId.
     *
     * @return int
     */
    public function getLazarusObjectId(): int;

    /**
     * Gets the value of lazarusClass.
     *
     * @return string
     */
    public function getLazarusClass(): string;

    /**
     * Fire an object event
     *
     * @param string $eventName Event Name
     * @return void
     */
    public function fire(string $eventName): void;

    /**
     * Add a listener to an event
     *
     * @param string $eventName Event Name
     * @param callable $eventHandler Event Handler Function
     * @return void
     */
    public function on(string $eventName, callable $eventHandler): void;
}
