<?php
/**
 * Defines PngWritter class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Io\Writer;

use Hjpbarcelos\GdWrapper\Io\Exception;
use Hjpbarcelos\GdWrapper\Io\Preset;

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
     * @see Hjpbarcelos\GdWrapper\Io\Writer\AbstractWriter::doWrite()
     * @link http://br.php.net/manual/en/function.imagepng.php imagepng
     * 		function on PHP Manual
     */
    protected function doWrite(
        $pathName,
        $quality = Preset::IMAGE_QUALITY_MAX,
        $filters = null
    ) {
        $quality = round((100 - $quality) / (111 / 9));

        return call_user_func_array(
            'imagepng',
            array(
                $this->getResource(),
                $pathName,
                $quality,
                $filters
            )
        );
    }
}
