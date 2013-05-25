<?php
/**
 * Defines AbstractReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

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
	public function read($pathName)
	{
		if (!is_file($pathName)) {
			throw new \InvalidArgumentException("Path '{$pathName}' does not point to a file");
		}
		
		if (!is_readable($pathName)) {
			throw new Exception("You do not have permissions to read the file '{$pathName}'");
		}
		
		$info = getimagesize($pathName);
		$this->validateMimeType($info['mime'], $pathName);
		
		return $this->doRead($pathName);
	}
	
	/**
	 * Concrete implementors should implement this operation.
	 * This is method is executed at the end of {@link \GdWrapper\Io\Reader\Reader::write()}
	 *
	 * @param string $pathName The path to a valid image.
	 *
	 * @return resource A GD2 image resource;
	 *
	 * @throws \GdWrapper\Io\Exception If cannot read from file system
	 */
	abstract protected function doRead($pathName);
	
	/**
	 * Validate expected image mime-type againt a parameter.
	 *
	 * @param string $mimeType The mime-type of the image.
	 * @param string $pathName The path to the image.
	 *
	 * @return void
	 *
	 * @throws \InvalidParameterException If `$mimeType` is not valid for the concrete implementation.
	 */
	abstract protected function validateMimeType($mimeType, $pathName);
}
