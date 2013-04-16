<?php
/**
 * Defines Writer interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use \GdWrapper\Io\Exception;
use \GdWrapper\Resource\Resource;
use \GdWrapper\Io\Preset;

/**
 * Represents an output "device" for resources.
 */
interface Writer {
	/**
	 * Provides an output to an image resource.
	 *
	 * @param string $path (optional) A path where to save the resource.
	 * @param int $quality (optional) The quality of generated image.
	 * 		Its value MUST be in a range from 0 to 100.
	 * @param mixed $_ (optional) Additional parameters passed to
	 * 		the concrete implementation method.
	 *
	 * @return void
	 *
	 * @throws Exception If cannot write the contents on file system.
	 *
	 * @see \GdWrapper\Io\Preset
	 */
	public function write(
		$path = null,
		$quality = Preset::IMAGE_QUALITY_MAX,
		$_ = null
	);
	
	/**
	 * Obtains the Resource instance in which this object is working on.
	 *
	 * @return \GdWrapper\Resource\Resource
	 */
	public function getResource();
	
	/**
	 * Obtains the Resource instance in which this object is working on.
	 *
	 * @param \GdWrapper\Resource\Resource $resource
	 * @return void
	 */
	public function setResource(Resource $resource);
}
