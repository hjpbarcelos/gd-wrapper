<?php
/**
 * Defines PngWritter class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Io\Writer;

use GdWrapper\Io\Exception;
use GdWrapper\Io\Preset;

/**
 * Defines an implementation of a I/O device for PNG files.
 */
class PngWriter extends AbstractWriter {
	/**
	 * Outputs an image resource with `imagepng` function.
	 *
	 * {@inheritdoc}
	 *
	 * @param string|null $path (optional) A `string` containing a path to a
	 * 		writable file on file system or `null` if you want send the
	 * 		output to the browser.
	 * @param int $filters (optional) Allows reducing the PNG file size.
	 *
	 * @see \GdWrapper\Io\Writer\AbstractWriter::doWrite()
	 * @link http://br.php.net/manual/en/function.imagepng.php imagepng 
	 * 		function on PHP Manual
	 */
	protected function doWrite(
		$path = null,
		$quality = Preset::IMAGE_QUALITY_MAX,
		$filters = null
	) {
		$quality = round((100 - $quality) / (111 / 9));

		if (!call_user_func_array('imagepng', array(
			$this->getResource()->getRaw(),
			$path,
			$quality,
			$filters
		))) {
			throw new Exception(
				"Failed to write image to path '{$path}'! Probably you do not
				have the right permissions to do so."
			);
		}
	}
}