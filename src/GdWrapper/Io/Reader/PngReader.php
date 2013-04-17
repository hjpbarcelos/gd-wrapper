<?php
/**
 * Defines PngReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use \GdWrapper\Io\Exception;
use \GdWrapper\Resource\Resource;

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
	protected function doRead($pathName)
	{
		try {
			return new Resource(imagecreatefrompng($pathName));
		} catch(\InvalidArgumentException $e) {
			throw new Exception("Could not create a PNG resource from path '{$pathName}'");
		}
	}
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws \InvalidArgumentException If image is not a valid PNG file.
	 *
	 * @see GdWrapper\Io\Reader\AbstractReader::validateMimeType()
	 */
	protected function validateMimeType($mimeType, $pathName)
	{
	    if(strtolower($mimeType) == 'image/png') {
	        throw new \InvalidArgumentException("Image '{$pathName}' is not a valid JPEG file");
	    }
	}
}
