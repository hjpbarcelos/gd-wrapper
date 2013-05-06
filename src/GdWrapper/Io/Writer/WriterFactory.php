<?php
/**
 * Defines WriterFactory class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Io\Reader\ReaderFactory;

/**
 * Defines an abstract implementation of an output "device" for resources.
 */
class WriterFactory
{
    /**
     * Returns a concrete instance of a Writer based on the file extension `$type`.
     *
     * Note:
     *
     * For custom implementations of `Writer` interface, it must follow the convention:
     * <code>
     * \GdWrapper\Io\Writer\&lt;TYPE&gt;Writer
     * </code>
     *
     * Notice that `&lt;TYPE&gt;` MUST be in `StudlyCaps`.
     *
     * @param string $type The type of the image that will be written.
     * @param resource $resource The GD2 image resource that will be written.
     *
     * @return \GdWrapper\Io\Writer\Writer A concrete implementation of Writer.
     *
     * @throws \DomainException If `$type` is not a supported file extension.
     * @throws \InvalidArgumentException If `$resource` is not a valid GD2 resource.
     */
    public function factory($type, $resource)
    {
        $className = __NAMESPACE__ . '\\' . ucfirst(strtolower($type)) . 'Writer';
        try {
            $reflection = new \ReflectionClass($className);
            return $reflection->newInstance($resource);
        } catch(\ReflectionClass $e) {
            throw new \DomainException("Extension '{$type}' not supported!");
        }
    }
}
