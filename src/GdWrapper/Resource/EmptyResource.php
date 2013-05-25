<?php
/**
 * Defines EmptyResource class.
 *
 * @author Henrique Barcelos
 */

namespace GdWrapper\Resource;

/**
 * Defines a true color image resource.
 */
class EmptyResource extends AbstractResource {
    /**
     * Creates a new blank image resource.
     *
     * @param int $width The width of the new image.
     * @param int $height The height of the new image.
     * @throws \InvalidArgumentException If `$width` or `$height` are less than zero.
     */
    public function __construct($width, $height)
    {
        if ((int) $width <= 0 || (int) $height <= 0) {
            throw new \InvalidArgumentException(
                "Imposible to create an image with dimensions [{$width}, {$height}]"
            );
        }
        
        $width = (int) $width;
        $height = (int) $height;
        
        $raw = imagecreatetruecolor($width, $height);
        $this->setRaw($raw);
    }
}