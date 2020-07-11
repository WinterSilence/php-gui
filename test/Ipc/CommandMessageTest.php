<?php

namespace Test\Ipc;

use Gui\Ipc\CommandMessage;use Gui\Ipc\MessageInterface;use PHPUnit\Framework\TestCase;

/**
 * Command Message Test.
 */
class CommandMessageTest extends TestCase
{
    public function testConstructor(): void
    {
        $method = 'method';
        $params = ['param1' => 'param1'];
        $foo = 0;
        $msg = new CommandMessage(
            $method,
            $params,
            static function () use (&$foo) {
                $foo++;
            }
        );

        static::assertEquals($msg->method, $method);
        static::assertEquals($msg->params, $params);
        $callback = $msg->callback;
        $callback();
        static::assertEquals(1, $foo);
        static::assertInstanceOf(MessageInterface::class, $msg);
    }
}
