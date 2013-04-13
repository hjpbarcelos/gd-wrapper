<?php
/**
 * Defines PngResource class.
 * 
 * @author Henrique Barcelos
 */
namespace GdWrapper\Resource;

use GdWrapper\Preset;

/**
 * Represents a PNG image resource.
 * 
 * @author Henrique Barcelos
 * @package GdWrapper\Resource
 **/
class PngResource extends AbstractResource
{
	/**
	 * Creates a resource with `imagecreatefrompng` function.
	 * 
	 * {@inheritdoc}
	 * @return JpegResource A new PngResource instance.
	 * @see GdWrapper\Resource.AbstractResource::doCreateResource()
	 */
	final protected function doCreateResource($filepath) 
	{
		return imagecreatefrompng($filepath);
	}

	/**
	 * Outputs a resource with `imagepng` function.
	 * 
	 * {@inheritdoc}
	 * @see GdWrapper\Resource.AbstractResource::doOutput()
	 */
	final protected function doOutput(
		$filename = null, 
		$quality = Preset::IMAGE_QUALITY_MAX,
		$additionalParameters = array()
	) {
		$funcArgs = func_get_args();
		if(count($funcArgs) > 2) {
			$additionalParameters = array_slice($funcArgs, 2);
		}

		if($filename === null) {
			$quality = 100;
		}

		if($quality !== null) {
			$quality = floor((100 - $quality) / (100/9));
		}

		$args = array_merge([$this->raw(), $filename, $quality], $additionalParameters);
		return call_user_func_array('imagepng', $args);
	}
}

