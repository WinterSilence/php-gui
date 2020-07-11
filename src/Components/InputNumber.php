<?php
namespace Gui\Components;

use Gui\Application;use Gui\Exception\ComponentException;

/**
 * This is the InputNumber Class It is a visual component for input numbers
 * - integer and float
 *
 * @author Everton da Rosa everton3x@gmail.com
 */
class InputNumber extends VisualObject
{
    /**
     * The lazarus class string to integer number control.
     *
     * @var string
     */
    protected $lazIntClass = 'TSpinEdit';

    /**
     * The lazarus class string to float number control.
     *
     * @var string
     */
    protected $lazFloatClass = 'TFloatSpinEdit';

    /**
     * The lazarus class as string
     *
     * @var string
     */
    protected $lazarusClass = '';

    /**
     * The class constructor.
     *
     * @param bool $isFloat If TRUE, define controlto manage float number.
     *     FALSE (default), to integer numbers.
     * @param array $defaultAttributes
     * @param ContainerObjectInterface $parent
     * @param Application $application
     */
    public function __construct(
        bool $isFloat = false,
        array $defaultAttributes = [],
        ContainerObjectInterface $parent = null,
        Application $application = null
    ) {
        if ($isFloat) {
            $this->lazarusClass = $this->lazFloatClass;
        } else {
            $this->lazarusClass = $this->lazIntClass;
        }
        parent::__construct($defaultAttributes, $parent, $application);
    }

    /**
     * Sets the value by which the value of the control should be
     * increased/decresed when the user clicks one of the arrows or one of the
     * keyboard up/down arrows.
     *
     * @param float $value
     *
     * @return $this
     */
    public function setIncrement(float $value): InputNumber
    {
        $this->set('Increment', $value);
        return $this;
    }

    /**
     * Gets the value by which the value of the control should be
     * increased/decresed when the user clicks one of the arrows or one of the
     * keyboard up/down arrows.
     *
     * @return float
     */
    public function getIncrement(): float
    {
        return $this->get('Increment');
    }

    /**
     * Sets de max value.
     *
     * @param float $max
     *
     * @return $this
     */
    public function setMax(float $max): InputNumber
    {
        $this->set('MaxValue', $max);
        return $this;
    }

    /**
     * Gets the max value.
     *
     * @return float
     */
    public function getMax(): float
    {
        return $this->get('MaxValue');
    }

    /**
     * Sets de min value.
     *
     * @param float $min
     *
     * @return $this
     */
    public function setMin(float $min): InputNumber
    {
        $this->set('MinValue', $min);
        return $this;
    }

    /**
     * Gets the min value.
     *
     * @return float
     */
    public function getMin(): float
    {
        return $this->get('MinValue');
    }

    /**
     * Sets the value of value.
     *
     * @param float $value the value
     * @return $this
     */
    public function setValue(float $value): InputNumber
    {
        $this->set('Value', $value);

        return $this;
    }

    /**
     * Gets the value of value;
     *
     * @return float
     */
    public function getValue(): float
    {
        return $this->get('Value');
    }

    /**
     * Sets decimals for control.
     *
     * @param float $decimal
     * @return $this
     * @throws ComponentException
     */
    public function setDecimals(float $decimal): InputNumber
    {
        if ($this->lazarusClass === $this->lazFloatClass) {
            $this->set('DecimalPlaces', $decimal);
            return $this;
        }
        throw new ComponentException(
            'Invalid call to setDecimal() at not type TFloatSpinEdit type'
        );
    }

    /**
     * Gest de decimal.
     *
     * @return float
     * @throws ComponentException
     */
    public function getDecimals(): float
    {
        if ($this->lazarusClass === $this->lazFloatClass) {
            return $this->get('DecimalPlaces');
        }
        throw new ComponentException(
            'Invalid call to getDecimal() at not type TFloatSpinEdit type'
        );
    }
}
