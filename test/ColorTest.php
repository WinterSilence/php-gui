<?php

namespace Test;

use Gui\Color;use InvalidArgumentException;use PHPUnit\Framework\TestCase;use function is_int;

/**
 * Color Test
 */
class ColorTest extends TestCase
{
    public function testColorToLazarus(): void
    {
        $lazarusColor = Color::toLazarus('#112233');
        static::assertIsInt($lazarusColor);
        static::assertEquals(3351057, $lazarusColor);

        $isInt = is_int(Color::toLazarus('112233'));
        static::assertTrue($isInt);
        static::assertNotEquals(3351057, $lazarusColor);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testShouldThrowExceptionWithInvalidHexColor(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Color::toLazarus('#11AAGG');
    }
}
