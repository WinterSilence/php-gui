<?php

namespace Gui\Components;

/**
 * This is the ContainerObjectInterface
 *
 * @author Rodrigo Azevedo @rodrigowbazeved
 */
interface ContainerObjectInterface extends LazarusObjectInterface
{
    /**
     * Append object as child
     *
     * @param VisualObjectInterface $object
     *
     * @return void
     */
    public function appendChild(VisualObjectInterface $object): void;

    /**
     * Get child
     *
     * @param int $lazarusObjectId the object id
     * @return VisualObjectInterface
     */
    public function getChild(int $lazarusObjectId): VisualObjectInterface;

    /**
     * Get children array
     *
     * @return array
     */
    public function getChildren(): array;
}
