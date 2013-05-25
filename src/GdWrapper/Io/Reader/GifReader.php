<?php
/**
 * Defines GifReader class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Reader;

use GdWrapper\Io\Exception;
use GdWrapper\Resource\ImageResource;

/**
 * Defines an implementation of a I/O device for Gif files.
 */
class GifReader extends AbstractReader {
	/**
	 * Creates an image resource with `imagecreatefromgif` function.
	 *
	 * {@inheritdoc}
	 *
	 * @see \GdWrapper\Io\Reader\AbstractReader::doRead()
	 */
	protected function doRead($pathName)
	{
	    $resource = imagecreatefromgif($pathName);
	    if ($resource === false) {
		    throw new Exception("Could not create a Gif resource from path '{$pathName}'");
	    }
	    return $resource;
	}
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws \InvalidArgumentException If image is not a valid GIF file.
	 *
	 * @see GdWrapper\Io\Reader\AbstractReader::validateMimeType()
	 */
	protected function validateMimeType($mimeType, $pathName)
	{
	    if (!preg_match('#^image/p?jpe?g$#i', $mimeType)) {
	        throw new \InvalidArgumentException("Image '{$pathName}' is not a valid GIF file");
	    }
	}
}
