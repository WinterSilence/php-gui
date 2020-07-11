<?php

namespace Gui\Components;

use InvalidArgumentException;use function file_exists;use function in_array;use function preg_match;use function ucfirst;

/**
 * This is the Window Class
 * It is a visual component for window
 *
 * @author Rafael Reis @reisraff
 */

class Window extends ContainerObject
{
    /**
     * The lazarus class as string
     *
     * @var string
     */
    protected $lazarusClass = 'TForm1';

    /**
     * Sets the window title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): Window
    {
        $this->set('caption', $title);

        return $this;
    }

    /**
     * Gets the window title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->get('caption');
    }

    /**
     * Sets the icon
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon): Window
    {
        if (file_exists($icon) && preg_match('/ico$/i', $icon)) {
            $this->call(
                'icon.loadFromFile',
                [$icon]
            );
        }
        return $this;
    }

    /**
     * Sets the window state. Can be one of the following values: fullscreen,
     * minimized, maximized, normal
     *
     * @param string $state
     * @return $this
     */
    public function setWindowState(string $state = 'normal'): Window
    {
        $validStates = [
            'fullscreen',
            'minimized',
            'maximized',
            'normal',
        ];

        if (! in_array($state, $validStates)) {
            throw new InvalidArgumentException(
                'Unknown state: ' . $state
            );
        }

        $this->set('windowState', 'ws' . ucfirst($state));

        return $this;
    }
}
