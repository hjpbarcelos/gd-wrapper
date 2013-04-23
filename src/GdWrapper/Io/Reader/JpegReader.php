<?php
/**
 * Defines JpegReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Io\Exception;
use GdWrapper\Resource\ImageResource;

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
	    $resource = imagecreatefromjpeg($path);
	    if ($resource === false) {
		    throw new Exception("Could not create a JPEG resource from path '{$path}'");
	    }
	    return $resource;
	}
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws \InvalidArgumentException If image is not a valid JPEG file.
	 *
	 * @see GdWrapper\Io\Reader\AbstractReader::validateMimeType()
	 */
	protected function validateMimeType($mimeType, $pathName)
	{
	    if (!preg_match('#^image/p?jpe?g$#i', $mimeType)) {
	        throw new \InvalidArgumentException("Image '{$pathName}' is not a valid JPEG file");
	    }
	}
}
