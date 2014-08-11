<?php
/**
 * Creates class \Hjpbarcelos\GdWrapper\Resource\EmptyResourceFactory
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Resource;

/**
 * Factory for creating new empty (blank) image resources.
 */
class TransparentResourceFactory extends EmptyResourceFactory
{
    /**
     * Creates a factory object that will create `ImageResource` objects
     * from `$resource`.
     *
     * @param int $width The width of the resources that will be created
     * @param int $height The height of the resources that will be created
     *
     * @throws \InvalidArgumentException If `$resource` is not a valid resource.
     */
    public function __construct($width, $height)
    {
        parent::__construct($width, $height);
        $this->setClassName('\\Hjpbarcelos\\GdWrapper\\Resource\\TransparentResource');
    }
}