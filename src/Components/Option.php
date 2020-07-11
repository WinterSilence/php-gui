<?php

namespace Gui\Components;

/**
 * This is the Option class
 *
 * @author Alex Silva
 */
class Option
{
    /**
     * The label for the option
     *
     * @var string $label
     */
    private $label;

    /**
     * The value for the option
     *
     * @var int $value
     */
    private $value;

    /**
     * Creates new instance.
     *
     * @param string $label
     * @param int $value
     */
    public function __construct(string $label, int $value)
    {
        $this->setLabel($label);
        $this->setValue($value);
    }

    /**
     * This method is used to set an string label for the object instance
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): Option
    {
        $this->label = $label;
        return $this;
    }

    /**
     * This method is used to set an integer value for the object instance
     *
     * @param int $value
     *
     * @return $this
     */
    public function setValue(int $value): Option
    {
        $this->value = $value;
        return $this;
    }

    /**
     * This method returns the instance Label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * This method returns the instance value
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
