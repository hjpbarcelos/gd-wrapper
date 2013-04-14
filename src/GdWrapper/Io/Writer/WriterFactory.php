<?php
/**
 * Defines WriterFactory class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Io\Reader\ReaderFactory;
use GdWrapper\Resource\Resource;

/**
 * Defines an abstract implementation of a input "device" for resources.
 */
class WriterFactory
{
	/**
	 * Returns a concrete instance of a AbstractWriter based on the file
	 * extension of `$path`.
	 * 
	 * @param string $type The type of the image that will be written.
	 * @param \GdWrapper\Resource\Resource $resource The image resource that 
	 * 		will be written.
	 * 
	 * @return \GdWrapper\Io\Writer\Writer A concrete implementation of Writer.
	 * 
	 * @throws \DomainException
	 */
	public static function factory($type, Resource $resource)
	{
		$className = __NAMESPACE__ . '\\' . ucfirst(strtolower($type)) 
					. 'Writer';
		try {
			return (new \ReflectionClass($className))->newInstance($resource);
		} catch(\ReflectionException $e) {
			throw new \DomainException("Extension '{$type}' not supported!");
		}
	}
}