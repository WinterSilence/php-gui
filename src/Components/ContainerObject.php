<?php

namespace Gui\Components;

use RuntimeException;

/**
 * It is a container component
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 */
abstract class ContainerObject extends VisualObject implements ContainerObjectInterface
{
    /**
     * The children objetcs
     *
     * @var AbstractObject[]
     */
    protected $children = [];

    /**
     * {@inheritdoc}
     * @param AbstractObject $object
     */
    public function appendChild(VisualObjectInterface $object): void
    {
        $this->children[$object->getLazarusObjectId()] = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getChild(int $lazarusObjectId): VisualObjectInterface
    {
        if (!isset($this->children[$lazarusObjectId])) {
            throw new RuntimeException("Child object not found");
        }

        return $this->children[$lazarusObjectId];
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren(): array
    {
        return $this->children;
    }
}
