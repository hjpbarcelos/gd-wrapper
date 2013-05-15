<?php
/**
 * Defines crop strategy interface.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

/**
 * Represents a cropping strategy.
 */
interface Strategy
{
    /**
     * Return the new dimensions of an image with `$width` and `$height` dimensions.
     *
     * @param int $width The width of the original image.
     * @param int $height The height of the original image.
     *
     * @return GdWrapper\Action\CropStrategy\CropInfo The information for cropping.
     *
     * @throws \InvalidArgumentException On error calculating crop info.
     */
    public function getCropInfo($width, $height);
}