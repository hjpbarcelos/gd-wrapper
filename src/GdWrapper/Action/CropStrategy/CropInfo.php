<?php
/**
 * Defines CropInfo class.
 * @author Henrique Barcelos
 */

namespace GdWrapper\Action\CropStrategy;

use GdWrapper\Geometry\Point;

/**
 * Information for cropping an image.
 */
class CropInfo
{
    /**
     * @var Point The start point of the cropping.
     */
    private $startPoint;

    /**
     * @var int The width of the cropping.
     */
    private $width;

    /**
     * @var int The height of the cropping.
     */
    private $height;

    /**
     * Information for cropping an image.
     *
     * @param Point $start
     * @param unknown_type $width
     * @param unknown_type $height
     */
    public function __construct(Point $start, $width, $height)
    {
        $this->setStartPoint($start);
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * Obtains the starting point of the cropping.
     *
     * @return \GdWrapper\Geometry\Point The starting point of the cropping.
     */
    public function getStartPoint()
    {
        return $this->startPoint;
    }

    /**
     * Sets the starting point of the cropping.
     *
     * @param Point $startPoint The starting point of the cropping.
     *
     * @return void
     */
    public function setStartPoint($startPoint)
    {
        $this->startPoint = $startPoint;
    }

    /**
     * Obtains the width of the cropping.
     *
     * @return int The width of the cropping.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets the width of the cropping.
     *
     * @param int $width The width of the cropping.
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    /**
     * Obtains the height of the cropping.
     *
     * @return int The height of the cropping.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets the height of the cropping.
     *
     * @param int $height The height of the cropping.
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }
}