<?php

namespace Gui\Components;

/**
 * It is a visual component interface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 */
interface VisualObjectInterface
{
    /**
     * Get the auto size
     *
     * @return bool
     */
    public function getAutoSize(): bool;

    /**
     * Set the auto size
     *
     * @param bool $autoSize True = Enabled
     *
     * @return static
     */
    public function setAutoSize(bool $autoSize): VisualObjectInterface;

    /**
     * Get the background color
     *
     * @return string
     */
    public function getBackgroundColor(): string;

    /**
     * Set the background Color
     *
     * @param string $color Color '#123456'
     *
     * @return static
     */
    public function setBackgroundColor(string $color): VisualObjectInterface;

    /**
     * Gets the value of bottom in pixel.
     *
     * @return int
     */
    public function getBottom(): int;

    /**
     * Sets the value of bottom in pixel.
     *
     * @param int $bottom the bottom margin
     * @return static
     */
    public function setBottom(int $bottom): VisualObjectInterface;

    /**
     * Gets the value of height in pixel.
     *
     * @return int
     */
    public function getHeight(): int;

    /**
     * Sets the value of height in pixel.
     *
     * @param int $height the height
     * @return static
     */
    public function setHeight(int $height): VisualObjectInterface;

    /**
     * Gets the value of left in pixel.
     *
     * @return int
     */
    public function getLeft(): int;

    /**
     * Sets the value of left in pixel.
     *
     * @param int $left the left margin
     *
     * @return static
     */
    public function setLeft(int $left): VisualObjectInterface;

    /**
     * Gets the value of right in pixel.
     *
     * @return int
     */
    public function getRight(): int;

    /**
     * Sets the value of right in pixel.
     *
     * @param int $right the right margin
     * @return static
     */
    public function setRight(int $right): VisualObjectInterface;

    /**
     * Gets the value of top in pixel.
     *
     * @return int
     */
    public function getTop(): int;

    /**
     * Sets the value of top in pixel.
     *
     * @param int $top the top margin
     * @return static
     */
    public function setTop(int $top): VisualObjectInterface;

    /**
     * Gets the value of width in pixel.
     *
     * @return int
     */
    public function getWidth(): int;

    /**
     * Sets the value of width in pixel.
     *
     * @param int $width the width
     * @return static
     */
    public function setWidth(int $width): VisualObjectInterface;

    /**
     * Gets the value of visible in pixel.
     *
     * @return bool
     */
    public function getVisible(): bool;

    /**
     * Sets the value of visible in pixel.
     *
     * @param bool $visible the visible
     *
     * @return static
     */
    public function setVisible(bool $visible): VisualObjectInterface;
}
