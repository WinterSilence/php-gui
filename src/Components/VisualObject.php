<?php

namespace Gui\Components;

use Gui\Color;

/**
 * It is a visual component
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 */
abstract class VisualObject extends AbstractObject
{
    /**
     * {@inheritdoc}
     */
    public function getAutoSize(): bool
    {
        return (bool) $this->get('autosize');
    }

    /**
     * {@inheritdoc}
     */
    public function setAutoSize(bool $autoSize): VisualObject
    {
        $this->set('autosize', $autoSize);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackgroundColor(): string
    {
        return $this->get('color');
    }

    /**
     * {@inheritdoc}
     */
    public function setBackgroundColor(string $color): VisualObject
    {
        $this->set('color', Color::toLazarus($color));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBottom(): int
    {
        return $this->get('bottom');
    }

    /**
     * {@inheritdoc}
     */
    public function setBottom(int $bottom): VisualObject
    {
        $this->set('bottom', $bottom);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->get('height');
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->set('height', $height);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLeft()
    {
        return $this->get('left');
    }

    /**
     * {@inheritdoc}
     */
    public function setLeft($left)
    {
        $this->set('left', $left);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRight()
    {
        return $this->get('right');
    }

    /**
     * {@inheritdoc}
     */
    public function setRight($right)
    {
        $this->set('right', $right);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTop()
    {
        return $this->get('top');
    }

    /**
     * {@inheritdoc}
     */
    public function setTop($top)
    {
        $this->set('top', $top);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->get('width');
    }

    /**
     * {@inheritdoc}
     */
    public function setWidth(int $width): VisualObject
    {
        $this->set('width', $width);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVisible(): bool
    {
        return $this->get('visible');
    }

    /**
     * {@inheritdoc}
     */
    public function setVisible(bool $visible): VisualObject
    {
        $this->set('visible', $visible);

        return $this;
    }
}
