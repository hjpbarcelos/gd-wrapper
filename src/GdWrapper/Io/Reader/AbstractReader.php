<?php
/**
 * Defines AbstractReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Resource\Resource;
use GdWrapper\Io\Preset;
use GdWrapper\Io\Exception;

/**
 * Defines an abstract implementation of a I/O device for resources.
 */
abstract class AbstractReader implements Reader
{
	/**
	 * {@inheritdoc}
	 * 
	 * @see \GdWrapper\Io\Reader\Reader::read()
	 */
	public function read($path)
	{
		if (!is_file($path)) {
			throw new \InvalidArgumentException(
				"Path '{$path}' does not point to a file"
			);
		}
		
		if (!is_readable($path)) {
			throw new Exception(
				"You do not have permissions to read the file '{$path}'"
			);	
		}
		
		return $this->doRead($path);
	}
	
	/**
	 * Concrete implementors should implement this operation.
	 * This is method is executed at the end of 
	 * {@link \GdWrapper\Io\Reader\Reader::write()}
	 *
	 * @param string $path The path to a valid image.
	 * @return Resource A new Resource object.
	 * @throws \GdWrapper\Io\Exception If cannot read from file system
	 */	
	abstract protected function doRead($path);
}