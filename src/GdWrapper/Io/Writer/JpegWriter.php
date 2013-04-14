<?php
/**
 * Defines JpegWritter class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Io\Exception;
use GdWrapper\Io\Preset;

/**
 * Defines an implementation of a I/O device for JPEG files.
 */
class JpegWriter extends AbstractWriter {
	/**
	 * Outputs an image resource with `imagejpeg` function.
	 * 
	 * {@inheritdoc}
	 * 
	 * @param string|null $path (optional) A `string` containing a path to a
	 * 		writable file on file system or `null` if you want send the
	 * 		output to the browser.
	 * 
	 * @see GdWrapper\Io\Writer::save()
	 */
	public function write(
		$path = null,
		$quality = Preset::IMAGE_QUALITY_MAX,
		$_ = null
	) {
		$args = func_get_args();
		if (count($args > 2)) {
			$args = array_slice($args, 0, 2);
		}
		
		$args = array_merge([$this->getResource()->getRaw()], $args);
		if (!call_user_func_array('imagejpeg', $args)) {
			throw new Exception(
				"Failed to write image to path '{$path}'! Probably you do not
					 have the right permissions to do so."
			);
		}
	}
}