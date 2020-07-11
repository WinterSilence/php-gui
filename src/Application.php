<?php

namespace Gui;

use Gui\Components\AbstractObject;use Gui\Components\LazarusObjectInterface;use Gui\Components\Window;use Gui\Ipc\CommandMessage;use Gui\Ipc\EventMessage;use Gui\Ipc\Receiver;use Gui\Ipc\Sender;use React\ChildProcess\Process;use React\EventLoop\Factory;use React\EventLoop\LoopInterface;use RuntimeException;use function implode;use function is_array;use function is_resource;use function microtime;use const PHP_EOL;

/**
 * This is the Application Class
 * This class is used to manipulate the application
 *
 * @author Gabriel Couto @gabrielrcouto
 */
class Application
{
    /**
     * The application object
     *
     * @var self
     */
    public static $defaultApplication;

    /**
     * The internal array of all callbacks
     *
     * @var array
     */
    protected $eventHandlers = [];

    /**
     * The application loop
     *
     * @var LoopInterface
     */
    protected $loop;

    /**
     * The next object ID available
     *
     * @var int
     */
    protected $objectId = 0;

    /**
     * The internal array of all Components Objects in this application
     *
     * @var LazarusObjectInterface[]
     */
    protected $objects = [];

    /**
     * The object responsible to manage the lazarus process
     *
     * @var Process
     */
    public $process;

    /**
     * Defines if the application is running
     *
     * @var bool
     */
    protected $running = false;

    /**
     * The responsible object to sent the communication messages
     *
     * @var Sender
     */
    protected $sender;

    /**
     * The responsible object to receive the communication messages
     *
     * @var Receiver
     */
    protected $receiver;

    /**
     * The verbose level
     *
     * @var int
     */
    protected $verboseLevel = 2;

    /**
     * The 1st Window of the Application
     *
     * @var Window
     */
    protected $window;

    /**
     * The constructor method
     *
     * @param array $defaultAttributes
     * @param LoopInterface $loop
     * @return void
     */
    public function __construct(array $defaultAttributes = [], LoopInterface $loop = null)
    {
        $this->window = new Window([], null, $this);
        $this->loop = $loop ?: Factory::create();
        $this->on(
            'start',
            function () use ($defaultAttributes) {
                foreach ($defaultAttributes as $attr => $value) {
                    $method = 'set' . ucfirst($attr);
                    if (method_exists($this->window, $method)) {
                        $this->window->$method($value);
                    }
                }
            }
        );
    }

    /**
     * Returns the 1st Window of the Application
     *
     * @return Window
     */
    public function getWindow(): Window
    {
        return $this->window;
    }

    /**
     * Returns the communication time between php and lazarus
     *
     * @return float
     */
    public function ping(): float
    {
        $now = microtime(true);
        $this->waitCommand(
            'ping',
            [(string) $now]
        );
        return microtime(true) - $now;
    }

    /**
     * Put a object to the internal objects array
     *
     * @param AbstractObject $object Component Object
     *
     * @return $this
     */
    public function addObject(AbstractObject $object): Application
    {
        $this->objects[$object->getLazarusObjectId()] = $object;
        return $this;
    }

    /**
     * Destroy a object
     *
     * @param AbstractObject $object Component Object
     * @return $this
     */
    public function destroyObject(AbstractObject $object): Application
    {
        $application = $this;
        $id = $object->getLazarusObjectId();
        $this->sendCommand(
            'destroyObject',
            [$id],
            static function ($result) use ($id, $application) {
                if ((int) $result === $id) {
                    if ($application->getObject($result)) {
                        unset($application->objects[$id]);
                    }
                }
            }
        );
        return $this;
    }

    /**
     * Fire an application event
     *
     * @param string $eventName Event name
     * @param array $args Arguments to event handler
     * @return $this
     */
    public function fire(string $eventName, array $args = []): Application
    {
        if (! isset($this->eventHandlers[$eventName])) {
            foreach ($this->eventHandlers[$eventName] as $eventHandler) {
                $eventHandler(...$args);
            }
        }
        return $this;
    }

    /**
     * Returns the next avaible object ID
     *
     * @return int
     */
    public function getNextObjectId(): int
    {
        return $this->objectId++;
    }

    /**
     * Get a object from the internal objects array
     *
     * @param int $id Object ID
     * @return null|LazarusObjectInterface
     */
    public function getObject(int $id): ?LazarusObjectInterface
    {
        return empty($this->objects[$id]) ? null : $this->objects[$id];
    }

    /**
     * Returns the verbose level
     *
     * @return int
     */
    public function getVerboseLevel(): int
    {
        return $this->verboseLevel;
    }

    /**
     * Returns the next avaible object ID
     *
     * @param string $eventName the name of the event
     * @param callable $eventHandler the callback
     * @return $this
     */
    public function on(string $eventName, callable $eventHandler): Application
    {
        if (! isset($this->eventHandlers[$eventName])) {
            $this->eventHandlers[$eventName] = [];
        }
        $this->eventHandlers[$eventName][] = $eventHandler;
        return $this;
    }

    /**
     * Runs the application
     *
     * @return void
     */
    public function run(): void
    {
        if (! static::$defaultApplication) {
            static::$defaultApplication = $this;
        }

        if (OsDetector::isMacOS()) {
            $processName = './phpgui-i386-darwin';
            $processPath = __DIR__ . '/../lazarus/phpgui-i386-darwin.app/Contents/MacOS/';
        } elseif (OsDetector::isFreeBSD()) {
            $processName = './phpgui-x86_64-freebsd';
            $processPath = __DIR__ . '/../lazarus/';
        } elseif (OsDetector::isUnix()) {
            switch (OsDetector::systemArchitecture()) {
                case 'x86_64':
                    $processName = './phpgui-x86_64-linux';
                    break;
                case 'i686':
                case 'i586':
                case 'i386':
                    $processName = './phpgui-i386-linux';
                    break;
                default:
                    throw new RuntimeException('Operational System architecture not identified by PHP-GUI.');
                    break;
            }
            $processPath = __DIR__ . '/../lazarus/';
        } elseif (OsDetector::isWindows()) {
            $processName = '.\\phpgui-x86_64-win64';
            $processPath = __DIR__ . '\\..\\lazarus\\';
        } else {
            throw new RuntimeException('Operational System not identified by PHP-GUI.');
        }

        $this->process = $process = new Process($processName, $processPath);

        $this->process->on(
            'exit',
            function () {
                $this->fire('exit');
                $this->running = false;
                $this->loop->stop();
            }
        );

        $this->receiver = $receiver = new Receiver($this);
        $this->sender = new Sender($this, $receiver);

        $this->loop->addTimer(
            0.001,
            function ($timer) use ($process, $receiver) {
                $process->start($timer->getLoop());
                // We need to pause all default streams
                // The react/loop uses fread to read data from streams
                // On Windows, fread always is blocking

                // Stdin is paused, we use our own way to write on it
                $process->stdin->pause();
                // Stdout is paused, we use our own way to read it
                $process->stdout->pause();
                // Stderr is paused for avoiding fread
                $process->stderr->pause();

                $process->stdout->on(
                    'data',
                    static function ($data) use ($receiver) {
                        $receiver->onData($data);
                    }
                );

                $process->stderr->on(
                    'data',
                    static function ($data) {
                        if (! empty($data)) {
                            Output::err($data);
                        }
                    }
                );
                $this->running = true;
                // Bootstrap the application
                $this->fire('start');
            }
        );

        $this->loop->addPeriodicTimer(
            0.001,
            function () {
                if (! $this->isRunning()) {
                    $this->terminate();
                }
                $this->sender->tick();
                if (is_resource($this->process->stdout->stream)) {
                    $this->receiver->tick();
                }
            }
        );

        $this->loop->run();
    }

    /**
     * Terminates the application
     *
     * @return void
     */
    public function terminate(): void
    {
        $this->sendCommand('exit');
        $this->process->terminate();
        $this->process->close();
    }

    /**
     * Send a command
     *
     * @param string $method the method name
     * @param array $params the method params
     * @param callable $callback the callback
     * @return void
     */
    public function sendCommand(string $method, array $params = [], callable $callback = null): void
    {
        // @todo: Put the message on a poll
        if ($this->running) {
            $message = new CommandMessage($method, $params, $callback);
            $this->sender->send($message);
        }
    }

    /**
     * Send an event
     *
     * @param string $method the method name
     * @param array $params the method params
     * @return void
     */
    public function sendEvent(string $method, array $params = []): void
    {
        // @todo: Put the message on a poll
        if ($this->running) {
            $message = new EventMessage($method, $params);
            $this->sender->send($message);
        }
    }

    /**
     * Set the verbose level
     *
     * @param int $verboseLevel
     * @return $this
     */
    public function setVerboseLevel(int $verboseLevel): Application
    {
        $this->verboseLevel = $verboseLevel;
        return $this;
    }

    /**
     * Send a command and wait the return
     *
     * @param string $method the method name
     * @param array $params the method params
     * @return mixed
     */
    public function waitCommand(string $method, array $params)
    {
        $message = new CommandMessage($method, $params);
        return $this->sender->waitReturn($message);
    }

    /**
     * Get the event loop
     *
     * @return LoopInterface
     */
    public function getLoop(): LoopInterface
    {
        return $this->loop;
    }

    /**
     * Shows an alert dialog
     *
     * @param string|string[] $message Array or String message to display
     * @param string $title Title of the alert
     * @return void
     */
    public function alert($message, string $title = ''): void
    {
        if (is_array($message)) {
            $message = implode(PHP_EOL, $message);
        }
        $this->sendCommand('showMessage', [(string) $message, $title]);
    }

    /**
     * Gets the Defines if the application is running.
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        $this->running = $this->process->isRunning() ? $this->running : false;
        return $this->running;
    }
}
