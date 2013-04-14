<?php
/**
 * Defines PngReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Resource\Resource;

/**
 * Defines an implementation of a I/O device for PNG files.
 */
class PngReader implements Reader {
	/**
	 * Creates an image resource with `imagecreatefrompng` function.
	 *
	 * {@inheritdoc}
	 * 
	 * @throws \InvalidArgumentException If $path does not point to a valid 
	 * 		PNG file.
	 * 
	 * @see GdWrapper\Io\Reader\Reader::read()
	 */
	public function read($path)
	{
		try {
			return new Resource(imagecreatefrompng($path));
		} catch(\InvalidArgumentException $e) {
			throw new \InvalidArgumentException(
				"Could not create a PNG resource from path '{$path}'"
			);
		}
	}
}