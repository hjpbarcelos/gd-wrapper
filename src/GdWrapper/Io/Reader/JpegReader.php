<?php
/**
 * Defines JpegReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Resource\Resource;

/**
 * Defines an implementation of a I/O device for JPEG files.
 */
class JpegReader implements Reader {
	/**
	 * Creates an image resource with `imagecreatefromjpeg` function.
	 *
	 * {@inheritdoc}
	 * 
	 * @throws \InvalidArgumentException If $path does not point to a valid 
	 * 		JPEG file.
	 * 
	 * @see GdWrapper\Io\Reader\Reader::read()
	 */
	public function read($path)
	{
		try {
			return new Resource(imagecreatefromjpeg($path));
		} catch(\InvalidArgumentException $e) {
			throw new \InvalidArgumentException(
				"Could not create a JPEG resource from path '{$path}'"
			);
		}
	}
}