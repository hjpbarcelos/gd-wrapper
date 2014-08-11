<?php
/**
 * Defines Point class.
 *
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry;

/**
 * Represents a discrete point in space Z^2.
 * This class implements the ValueObject pattern.
 */
class Point
{
    /**
     * @var int The X coordinate of the point.
     */
    private $x;

    /**
     * @var int The Y coordinate of the point.
     */
    private $y;

    /**
     * Creates a discrete point object.
     *
     * @param int $x The X coordinate of the point.
     * @param int $y The Y coordinate of the point.
     */
    public function __construct($x, $y)
    {
        $this->setupDimensions($x, $y);
    }

    /**
     * First setup object.
     *
     * This method is needed because Point is a ValueObject,
     * therefore `setDimensions` method will return a new object.
     *
     * @param int $x The X coordinate of the point.
     * @param int $y The Y coordinate of the point.
     *
     * @return void
     */
    private function setupDimensions($x, $y)
    {
        $this->x = (int) $x;
        $this->y = (int) $y;
    }

    /**
     * This method will create a new `Point` object with the following coordinates.
     *
     * @param int $x The X coordinate of the point.
     * @param int $y The Y coordinate of the point.
     *
     * @return Point A new point object with these coordinates.
     */
    public function setDimensions($x, $y)
    {
        return new self($x, $y);
    }

    /**
     * This method will create a new `Point` object with the following X coordinate
     * and the Y coordinate of this object.
     * 
     * @param int $x The X coordinate of the point.
     * 
     * @return Point A new point object with this coordinate.
     */
    public function setX($x)
    {
        return new self($x, $this->y);
    }
    
    /**
     * This method will create a new `Point` object with the following Y coordinate
     * and the Y coordinate of this object.
     * 
     * @param int $y The Y coordinate of the point.
     * 
     * @return Point A new point object with this coordinate.
     */
    public function setY($y)
    {
        return new self($this->x, $y);
    }
    
    /**
     * Obtains the X Coordinate of the Point.
     * 
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }
    
    /**
     * Obtains the Y Coordinate of the Point.
     * 
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }
}
