<?php
/**
 * Defines JpegWritter class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use \GdWrapper\Io\Exception;
use \GdWrapper\Io\Preset;

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
	 * @see \GdWrapper\Io\Writer\AbstractWriter::doWrite()
	 */
	protected function doWrite(
		$path = null,
		$quality = Preset::IMAGE_QUALITY_MAX,
		$_ = null
	) {
		if (!call_user_func_array('imagejpeg', array(
			$this->getResource()->getRaw(),
			$path,
			$quality
		))) {
			throw new Exception(
				"Failed to write image to path '{$path}'! Probably you do not
				have the right permissions to do so."
			);
		}
	}
}
