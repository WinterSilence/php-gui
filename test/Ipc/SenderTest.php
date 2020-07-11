<?php

namespace Test\Ipc;

use Gui\Application;use Gui\Ipc\Receiver;use Gui\Ipc\Sender;use PHPUnit\Framework\TestCase;

/**
 * Sender Test
 */
class SenderTest extends TestCase
{
    public function testConstructor(): void
    {
        $application = new Application();
        $receiver = new Receiver($application);

        $sender = new Sender($application, $receiver);

        static::assertInstanceOf(Application::class, $sender->application);
        static::assertInstanceOf(Receiver::class, $sender->receiver);
    }
}
