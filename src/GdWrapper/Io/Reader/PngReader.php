<?php
/**
 * Defines PngReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Io\Exception;
use GdWrapper\Resource\Resource;

/**
 * Defines an implementation of a I/O device for PNG files.
 */
class PngReader extends AbstractReader { 
	/**
	 * Creates an image resource with `imagecreatefrompng` function.
	 *
	 * {@inheritdoc}
	 * 
	 * @see \GdWrapper\Io\Reader\AbstractReader::doRead()
	 */
	protected function doRead($path)
	{
		try {
			return new Resource(imagecreatefrompng($path));
		} catch(\InvalidArgumentException $e) {
			throw new Exception(
				"Could not create a PNG resource from path '{$path}'"
			);
		}
	}
}