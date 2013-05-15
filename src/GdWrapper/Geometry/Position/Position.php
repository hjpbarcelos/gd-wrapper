<?php
/**
 * Defines Orientation interface.
 * 
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Position;

use GdWrapper\Geometry\Point;

/**
 * Abstraction for the positioning of an operation. 
 */
interface Position
{
	/**
	 * Will return the start point of an operation over an image based on these parameters.
	 * 
	 * @param \GdWrapper\Geometry\Point $outsideDimensions The dimensions of the outter image.
	 * @param \GdWrapper\Geometry\Point $insideDimensions The dimensions of the inner image.
	 * 
	 * return \GdWrapper\Geometry\Point The start point of the operation.
	 */
	public function getStartPoint(Point $outsideDimensions, Point $insideDimensions);
}