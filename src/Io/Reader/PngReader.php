<?php
/**
 * Defines PngReader class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Io\Reader;

use Hjpbarcelos\GdWrapper\Io\Exception;
use Hjpbarcelos\GdWrapper\Resource\ImageResource;

/**
 * Defines an implementation of a I/O device for PNG files.
 */
class PngReader extends AbstractReader {
	/**
	 * Creates an image resource with `imagecreatefrompng` function.
	 *
	 * {@inheritdoc}
	 *
	 * @see Hjpbarcelos\GdWrapper\Io\Reader\AbstractReader::doRead()
	 */
	protected function doRead($pathName)
	{
		$resource = imagecreatefrompng($pathName);
	    if ($resource === false) {
		    throw new Exception("Could not create a JPEG resource from path '{$path}'");
	    }
	    
// 	    imagealphablending($resource, false);
// 	    imagesavealpha($resource, true);
	    
	    return $resource;
	}
	
	/**
	 * {@inheritdoc}
	 *
	 * @throws \InvalidArgumentException If image is not a valid PNG file.
	 *
	 * @see Hjpbarcelos\GdWrapper\Io\Reader\AbstractReader::validateMimeType()
	 */
	protected function validateMimeType($mimeType, $pathName)
	{
	    if (strtolower($mimeType) != 'image/png') {
	        throw new \InvalidArgumentException("Image '{$pathName}' is not a valid JPEG file");
	    }
	}
}
