<?php

namespace Test;

use Gui\Application;use Gui\Components\AbstractObject;use Gui\Components\Window;use PHPUnit\Framework\TestCase;use React\EventLoop\LoopInterface;

/**
 * Application Test
 */
class ApplicationTest extends TestCase
{
    public function testGetNextObjectId(): void
    {
        $application = new Application();

        // zero is for the object window
        self::assertEquals(1, $application->getNextObjectId());
        self::assertEquals(2, $application->getNextObjectId());
        self::assertEquals(3, $application->getNextObjectId());
    }

    public function testGetWindow(): void
    {
        $application = new Application();

        static::assertInstanceOf(Window::class, $application->getWindow());
    }

    public function testGetLoop(): void
    {
        $application = new Application();

        static::assertInstanceOf(LoopInterface::class, $application->getLoop());
    }

    public function testPing(): void
    {
        $mock = $this->getMockBuilder(Application::class, ['waitCommand'])
            ->getMock();

        $mock->expects(static::once())
            ->method('waitCommand')
            ->willReturn(null);

        static::assertTrue(is_float($mock->ping()));
    }

    public function testAddObject(): void
    {
        $application = new Application();

        self::assertNull($application->getObject(1));

        $application->addObject(new Window([], null, $application));

        self::assertInstanceOf(Window::class, $application->getObject(1));
    }

    public function testOnAndFire(): void
    {
        $application = new Application();

        $bar = 0;
        $application->on('foo', static function () use (&$bar) {
            $bar++;
        });

        $application->fire('foo');

        self::assertEquals(1, $bar);
    }

    public function testGetAndSetVerboseLevel(): void
    {
        $application = new Application();

        self::assertEquals(2, $application->getVerboseLevel());
        $application->setVerboseLevel(1);
        self::assertEquals(1, $application->getVerboseLevel());
    }

    public function testDestroyObject(): void
    {
        $appMock = $this->getMockBuilder(
            Application::class,
            ['getWindow', 'sendCommand']
        )->getMock();

        $window = $this->getMockBuilder(
            Window::class,
            [
                [],
                null,
                $appMock,
            ]
        )
            ->disableOriginalConstructor()
            ->getMock();

        $appMock->expects(self::any())
            //->method('getWindow')
            ->willReturn($window);

        $mock = $this->getMockForAbstractClass(
            AbstractObject::class,
            [
                [],
                null,
                $appMock,
            ]
        );

        $appMock->expects(self::once())
            ->method('sendCommand')
            ->with(
                'destroyObject',
                [$mock->getLazarusObjectId()]
            );

        $appMock->destroyObject($mock);
    }
}
