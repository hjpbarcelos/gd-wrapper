<?php
/**
 * Defines JpegReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use \GdWrapper\Io\Exception;
use \GdWrapper\Resource\Resource;

/**
 * Defines an implementation of a I/O device for JPEG files.
 */
class JpegReader extends AbstractReader {
	/**
	 * Creates an image resource with `imagecreatefromjpeg` function.
	 *
	 * {@inheritdoc}
	 *
	 * @see \GdWrapper\Io\Reader\AbstractReader::doRead()
	 */
	protected function doRead($path)
	{
		try {
			return new Resource(imagecreatefromjpeg($path));
		} catch(\InvalidArgumentException $e) {
			throw new Exception("Could not create a JPEG resource from path '{$path}'");
		}
	}
}
