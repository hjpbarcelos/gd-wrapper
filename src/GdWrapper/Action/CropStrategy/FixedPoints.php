<?php
/**
 * Defines a crop strategy with proportional size edges.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Action\CropStrategy;

use GdWrapper\Geometry\Point;

/**
 * This crop strategy crops from a point to another point.
 */

class FixedPoints implements Strategy
{
    /**
     * @var \GdWrapper\Geometry\Point The start point of cropping.
     */
    private $start;
    
    /**
     * @var \GdWrapper\Geometry\Point The end point of cropping.
     */
    private $end;
    
    /**
     * Creates a FixedPoints crop strategy.
     * 
     * @param Point $start The start point of cropping.
     * @param Point $end The end point of cropping.
     */
    public function __construct(Point $start, Point $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
    }
    
    /**
     * Sets the start point of cropping.
     * 
     * @param Point $start The start point of cropping.
     * 
     * @return void
     */
    public function setStart(Point $start)
    {
        $this->start = $start;
    }
    
    /**
     * Sets the end point of cropping.
     * 
     * @param Point $end The end point of cropping.
     * 
     * @return void
     */
    public function setEnd(Point $end)
    {
        $this->end = $end;
    }
    
    /**
     * (non-PHPdoc)
     * @see GdWrapper\Action\CropStrategy\Strategy::getCropInfo()
     */
    public function getCropInfo($width, $height)
    {
        return new CropInfo(
            $this->start, 
            $this->end->getX() - $this->start->getX(), 
            $this->end->getY() - $this->start->getY()
        );
    }
}