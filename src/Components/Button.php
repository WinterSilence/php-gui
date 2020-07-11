<?php

namespace Gui\Components;

/**
 * This is the Button Class. It is a visual component for button.
 *
 * @author Gabriel Couto @gabrielrcouto
 */
class Button extends VisualObject
{
    /**
     * The lazarus class as string
     *
     * @var string
     */
    protected $lazarusClass = 'TButton';

    /**
     * Get the Button value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->get('caption');
    }

    /**
     * Set the button value
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue(string $value): Button
    {
        $this->set('caption', $value);
        return $this;
    }

    /**
     * Method called on "click" event.
     *
     * @return void
     */
    public function click(): void
    {
        // @todo put your code here
    }
}
