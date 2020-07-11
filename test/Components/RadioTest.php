<?php

namespace Test\Components;

use Gui\Application;use Gui\Components\Option;use Gui\Components\Radio;use InvalidArgumentException;use PHPUnit\Framework\TestCase;

/**
* Class RadioTest.
 */
class RadioTest extends TestCase
{
    public function testSetOptions(): void
    {
        $radio = new Radio([], null, new Application());

        static::assertSame($radio, $radio->setOptions([new Option('foo', 1)]));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testShouldThrowExceptionWithSetOptionsInvalidIntegerArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $radio = new Radio([], null, new Application());
        $radio->setOptions([1]);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testShouldThrowExceptionWithSetOptionsInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $radio = new Radio([], null, new Application());
        $radio->setOptions(['foo' => 'bar']);
    }
}
