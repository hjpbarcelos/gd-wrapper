<?php
/**
 * Defines Proportional class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

use \GdWrapper\Geometry\Position\Position;
use \GdWrapper\Geometry\Point;

/**
 * Representa a proportional positioned cropping strategy.
 */
class Proportional extends Positioned
{
    /**
     * @var float The proportion of the cropping relative to the original image size.
     */
    private $proportion;
    
    /**
     * Creates a proportional positioned cropping strategy.
     *
     * Note: the parameter `$proportion` is a floating point number which represents the scaling
     * of the cropped image. For example:
     *
     * * `1` means that the resulting image will have the same size of the original.
     * * `0.5` means that the resulting image will have half size of the original.
     * * `1.2` means that the resulting image will be 20% larger than the original.
     *
     * @param Position $position The position of the cropping.
     * @param float $proportion The proportion of the cropping relative to the original image size.
     */
    public function __construct(Position $position, $proportion)
    {
        parent::__construct($position);
        $this->setProportion($proportion);
    }

    /**
     * Obtains the proportion of the cropping operation.
     *
     * @return float
     */
    public function getProportion()
    {
        return $this->proportion;
    }

    /**
     * Sets the proportion of the cropping operation.
     *
     * @param $proportion
     */
    public function setProportion($proportion)
    {
        $this->proportion = (float) $proportion;
    }
    
    /**
     * {@inherit-doc}
     * @see GdWrapper\Action\CropStrategy\Strategy::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        $newWidth = (int) ($this->proportion * $width);
        $newHeight = (int) ($this->proportion * $height);
        return new CropInfo(
            $this->getPosition()->getStartPoint(
                new Point($width, $height),
                new Point($newWidth, $newHeight)
            ),
            $newWidth,
            $newHeight
        );
    }
}