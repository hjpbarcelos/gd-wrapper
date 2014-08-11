<?php
/**
 * Defines JpegReader class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Io\Reader;

use Hjpbarcelos\GdWrapper\Io\Exception;
use Hjpbarcelos\GdWrapper\Resource\ImageResource;

/**
 * Defines an implementation of a I/O device for JPEG files.
 */
class JpegReader extends AbstractReader {
	/**
	 * Creates an image resource with `imagecreatefromjpeg` function.
	 *
	 * {@inheritdoc}
	 *
	 * @see Hjpbarcelos\GdWrapper\Io\Reader\AbstractReader::doRead()
	 */
	protected function doRead($pathName)
	{
	    $resource = imagecreatefromjpeg($pathName);
	    if ($resource === false) {
		    throw new Exception("Could not create a JPEG resource from path '{$pathName}'");
	    }
	    return $resource;
	}
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws \InvalidArgumentException If image is not a valid JPEG file.
	 *
	 * @see Hjpbarcelos\GdWrapper\Io\Reader\AbstractReader::validateMimeType()
	 */
	protected function validateMimeType($mimeType, $pathName)
	{
	    if (!preg_match('#^image/p?jpe?g$#i', $mimeType)) {
	        throw new \InvalidArgumentException("Image '{$pathName}' is not a valid JPEG file");
	    }
	}
}
