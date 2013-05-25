<?php
/**
 * Defines ReaderFactory class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

/**
 * Defines an abstract implementation of an input "device" for resources.
 */
class ReaderFactory
{
    /**
     * Returns a concrete instance of a Reader based on the file extension of `$pathName`.
     *
     * For custom implementations of `Reader` interface, it must follow the convention:
     * <code>
     * \GdWrapper\Io\Reader\&lt;TYPE&gt;Writer
     * </code>
     *
     * Notice that `&lt;TYPE&gt;` MUST be in `StudlyCaps`.
     *
     * @param string $type The type (extension) of the image or the path to it.
     *     If you provide a path, extension will be obtained internally.
     *
     * @return \GdWrapper\Io\Reader\Reader A reader for `$pathName`.
     *
     * @throws \DomainException If `$pathName` is not a supported type image.
     */
    public function factory($type) {
        if (strpos($type, '.') !== false) {
            $type = pathinfo($type, PATHINFO_EXTENSION);
        }
        
        $className = __NAMESPACE__ . '\\' . ucfirst(strtolower($type)) . 'Reader';
        try {
            $reflection = new \ReflectionClass($className);
            return $reflection->newInstance();
        } catch(\ReflectionException $e) {
            throw new \DomainException("Extension '{$type}' not supported!");
        }
    }
}
