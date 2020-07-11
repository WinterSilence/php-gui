<?php

namespace Test\Components;

use Gui\Application;use Gui\Components\AbstractObject;use PHPUnit\Framework\TestCase;

/**
* Object Test
 */
class ObjectTest extends TestCase
{
    public function testMagicCall(): void
    {
        $mock = $this->getMockForAbstractClass(
            AbstractObject::class,
            [
                [],
                null,
                new Application(),
            ]
        );

        $mock
            //->expects(self::any())
            ->method('__call');


        $mock->setFoo(1);
        static::assertEquals(1, $mock->getFoo());
    }

    public function testOnAndFire(): void
    {
        $appMock = $this->getMockBuilder(Application::class, ['sendCommand'])
            ->getMock();

        $appMock
            //->expects(self::any())
            ->method('sendCommand');

        $mock = $this->getMockForAbstractClass(
            AbstractObject::class,
            [
                [],
                null,
                $appMock,
            ]
        );

        $bar = 0;
        $mock->on('foo', static function () use (&$bar) {
            $bar++;
        });

        $mock->fire('onfoo');

        static::assertEquals(1, $bar);
    }

    public function testGetLazarusClass(): void
    {
        $mock = $this->getMockForAbstractClass(
            AbstractObject::class,
            [
                [],
                null,
                new Application,
            ]
        );

        static::assertEquals('TObject', $mock->getLazarusClass());
    }

    public function testGetLazarusObjectId(): void
    {
        $mock = $this->getMockForAbstractClass(
            AbstractObject::class,
            [
                [],
                null,
                new Application,
            ]
        );

        static::assertEquals(1, $mock->getLazarusObjectId());
    }
}
