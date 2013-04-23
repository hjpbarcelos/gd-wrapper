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
class PngWriter extends AbstractWriter
{
    /**
     * Outputs an image resource with `imagepng` function.
     *
     * {@inheritdoc}
     *
     * @param int $filters (optional) Allows reducing the PNG file size.
     *
     * @see \GdWrapper\Io\Writer\AbstractWriter::doWrite()
     * @link http://br.php.net/manual/en/function.imagepng.php imagepng
     * 		function on PHP Manual
     */
    protected function doWrite(
        $pathName,
        $quality = Preset::IMAGE_QUALITY_MAX,
        $filters = null
    ) {
        $quality = round((100 - $quality) / (111 / 9));

        if (!call_user_func_array('imagepng', array(
            $this->getResource()->getRaw(),
            $pathName,
            $quality,
            $filters
        ))) {
            throw new Exception(
                "Failed to write image to path '{$pathName}'! Probably you do not
                have the right permissions to do so."
                );
        }
    }
}
