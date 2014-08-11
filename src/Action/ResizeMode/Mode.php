<?php
/**
 * Defines resize mode interface.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\ResizeMode;

interface Mode
{
    /**
     * Return the new dimensions of an image with `$width` and `$height` dimensions.
     *
     * @param int $width The width of the original image.
     * @param int $height The height of the original image.
     *
     * @return Hjpbarcelos\GdWrapper\Geometry\Point A point where the X coordinate represents
     *     the width and the Y corrdinate represents the height.
     *
     * @throws \InvalidArgumentException On error calculating new image dimensions.
     */
    public function getNewDimensions($width, $height);
}