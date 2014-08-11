<?php
/**
 * Defines the KeepRatio resizing mode.
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\ResizeMode;

use Hjpbarcelos\GdWrapper\Geometry\Point;

/**
 * Represents a resizing that respects image aspect ratio.
 */
class KeepRatio implements Mode
{
    /**
     * @var int The image max width.
     */
    private $maxWidth;
    
    /**
     * @var int The image max height.
     */
    private $maxHeight;

    /**
     * Creates a proportional resizing mode object.
     *
     * IMPORTANT:
     * Resulting image dimensions will NOT surpass `$maxWidth` and `$maxHeight` parameters.
     * If the proportion of an image is different from the proportion between those two
     * parameters, will be returned the dimensions that fit in  `$maxWidth` and `$maxHeight`.
     *
     * For example, if you try to resize an image with `1920 x 1080 px` (16:9) to
     * `400 x 300 px` (4:3), the new dimensions will be `400 x 225 px`.
     *
     * @param int $maxWidth The maximum width of the image.
     * @param int $maxHeight The maximum height of the image.
     *
     * @throws \InvalidArgumentException If `$maxWidth <= 0` or `$maxHeight <= 0` .
     */
    public function __construct($maxWidth, $maxHeight)
    {
        $this->setMaxWidth($maxWidth);
        $this->setMaxHeight($maxHeight);
    }
    
    /**
     * Gets the desired max width of the image.
     *
     * @return int
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }
    
    /**
     * Sets the desired max width of the image.
     *
     * @param int $maxWidth
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$width <= 0` .
     */
    public function setMaxWidth($maxWidth)
    {
        $maxWidth = (int) $maxWidth;
        if ($maxWidth <= 0) {
            throw new \InvalidArgumentException("Invalid max width: {$maxWidth}");
        }
        
        $this->maxWidth = $maxWidth;
    }
    
    /**
     * Gets the desired max height of the image.
     *
     * @return int
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }
    
    /**
     * Sets the desired max width of the image.
     *
     * @param int $maxHeight
     *
     * @return void
     *
     * @throws \InvalidArgumentException If `$height <= 0` .
     */
    public function setMaxHeight($maxHeight)
    {
        $maxHeight = (int) $maxHeight;
        if ($maxHeight <= 0) {
            throw new \InvalidArgumentException("Invalid max height: {$maxHeight}");
        }
        
        $this->maxHeight = $maxHeight;
    }

    /**
     * {@inheritdoc}
     *
     * @see Hjpbarcelos\GdWrapper\Action\ResizeMode\Mode::getNewDimensions()
     *
     * @throws \InvalidArgumentException If `$width <= 0` or `$height <= 0` .
     */
    public function getNewDimensions($width, $height)
    {
        $width = (int) $width;
        $height = (int) $height;
        
        if ($width == 0 || $height == 0) {
            throw new \InvalidArgumentException(
                "Invalid initial dimensions: [{$width}, {$height}]"
            );
        }
        
        $minRatio = min(
            ($this->maxWidth / $width),
            ($this->maxHeight / $height)
        );
        
        return new Point(
            round($width * $minRatio),
            round($height * $minRatio)
        );
    }
}