<?php
/**
 * Defines FixedDimensions class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Action\CropMode;

use Hjpbarcelos\GdWrapper\Geometry\Position\Position;
use Hjpbarcelos\GdWrapper\Geometry\Point;

/**
 * Represents a crop mode with fixed dimensions.
 * From the starting point, it will crop pixels of defined width and height.
 */
class FixedDimensions extends Positioned
{
    /**
     * @var int The width of the cropping.
     */
    private $width;
    
    /**
     * @var int The height of the cropping.
     */
    private $height;
    
    /**
     * Creates a crop mode with fixed dimensions.
     * From the starting point, it will crop pixels of defined width and height.
     *
     * @param Hjpbarcelos\GdWrapper\Geometry\Position\Position $position The position of the cropping.
     * @param int $width The width of the cropping.
     * @param int $height The height of the cropping.
     */
    public function __construct(Position $position, $width, $height)
    {
        $this->setPosition($position);
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * Obtains the width of cropping.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the width of cropping.
     *
     * @param int $width
     * @return void
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    /**
     * Obtains the height of cropping.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Obtains the height of cropping.
     *
     * @return int
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
    
    /**
     * {@inherit-doc}
     * @see Hjpbarcelos\GdWrapper\Action\CropMode\Mode::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        return new CropInfo(
            $this->getPosition()->getStartPoint(
                new Point($width, $height),
                new Point($this->width, $this->height)
            ),
            $this->width,
            $this->height
        );
    }
}
