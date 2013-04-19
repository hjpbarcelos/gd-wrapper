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
class JpegWriter extends AbstractWriter
{
    /**
     * Outputs an image resource with `imagejpeg` function.
     *
     * {@inheritdoc}
     *
     * @see \GdWrapper\Io\Writer\AbstractWriter::doWrite()
     */
    protected function doWrite(
        $pathName,
        $quality = Preset::IMAGE_QUALITY_MAX,
        $_ = null
    ) {
        if (!call_user_func_array('imagejpeg', array(
            $this->getResource()->getRaw(),
            $pathName,
            $quality
        ))) {
            throw new Exception(
                "Failed to write image to path '{$pathName}'! Probably you do not
                have the right permissions to do so."
                );
        }
    }
}
