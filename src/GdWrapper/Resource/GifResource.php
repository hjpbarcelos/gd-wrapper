<?php
/**
 * Defines GifResource class.
 * 
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

use GdWrapper\Preset;

/**
 * Represents a GIF image resource.
 * 
 * @author Henrique Barcelos
 * @package GdWrapper\Resource
 **/
class GifResource extends AbstractResource
{
	/**
	 * Creates a resource with `imagecreatefromgif` function.
	 * 
	 * {@inheritdoc}
	 * @return JpegResource A new GifResource instance.
	 * @see GdWrapper\Resource.AbstractResource::doCreateResource()
	 */
	final protected function doCreateResource($filepath) 
	{
		return imagecreatefromgif($filepath);
	}

	/**
	 * Outputs a resource with `imagegif` function.
	 *
	 * {@inheritdoc}
	 * @see GdWrapper\Resource.AbstractResource::doOutput()
	 */
	final protected function doOutput(
		$filename = null, 
		$quality = Preset::IMAGE_QUALITY_MAX,
		$additionalParameters = null
	) {
		$args = [$this->raw(), $filename];
		return call_user_func_array('imagegif', $args);
	}
}

