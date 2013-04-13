<?php
/**
 * Defines JpegResource class.
 * 
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;
namespace GdWrapper\Resource;

use GdWrapper\Preset;

/**
 * Represents a Jpeg image resource.
 * 
 * @author Henrique Barcelos
 * @package GdWrapper\Resource
 **/
class JpegResource extends AbstractResource
{
	/**
	 * Creates a resource with `imagecreatefromjpeg` function.
	 *  
	 * {@inheritdoc}
	 * @return JpegResource A new JpegResource instance.
	 * @see GdWrapper\Resource.AbstractResource::doCreateResource()
	 */
	final protected function doCreateResource($filepath) 
	{
		return imagecreatefromjpeg($filepath);
	}

	/**
	 * Outputs a resource with `imagejpeg` function.
	 * 
	 * {@inheritdoc}
	 * @see GdWrapper\Resource.AbstractResource::doOutput()
	 */
	final protected function doOutput(
		$filename = null, 
		$quality = Preset::IMAGE_QUALITY_MAX,
		$additionalParameters = null
	) {
		$args = array_merge([$this->raw()], func_get_args());
		return call_user_func_array('imagejpeg', $args);
	}
}

