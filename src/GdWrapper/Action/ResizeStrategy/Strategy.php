<?php
/**
 * Defines resize strategy interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\ResizeStrategy;

/**
 * Represents a resizing strategy.
 */
interface Strategy
{
    /**
     * Return the new dimensions of an image with `$width` and `$height` dimensions.
     *
     * @param int $width The width of the original image.
     * @param int $height The height of the original image.
     *
     * @return array An array like: `['width' => value, 'height' => value]`
     *
     * @throws \InvalidArgumentException On error calculating new image dimensions.
     */
    public function getNewDimensions($width, $height);
}