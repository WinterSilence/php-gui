<?php

namespace Test\Ipc;

use Gui\Ipc\CommandMessage;use Gui\Ipc\MessageInterface;use PHPUnit\Framework\TestCase;

/**
* Event Message Test.
 */
class EventMessageTest extends TestCase
{
    public function testConstructor(): void
    {
        $method = 'method';
        $params = ['param1' => 'param1'];
        $event = new CommandMessage($method, $params);

        static::assertEquals($event->method, $method);
        static::assertEquals($event->params, $params);
        static::assertInstanceOf(MessageInterface::class, $event);
    }
}
