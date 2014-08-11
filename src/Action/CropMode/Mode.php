<?php
/**
 * Defines crop mode interface.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\CropMode;

/**
 * Represents a cropping mode.
 */
interface Mode
{
    /**
     * Return the new dimensions of an image with `$width` and `$height` dimensions.
     *
     * @param int $width The width of the original image.
     * @param int $height The height of the original image.
     *
     * @return Hjpbarcelos\GdWrapper\Action\CropMode\CropInfo The information for cropping.
     *
     * @throws \InvalidArgumentException On error calculating crop info.
     */
    public function getCropInfo($width, $height);
}