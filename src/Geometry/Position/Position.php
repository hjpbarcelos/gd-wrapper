<?php
/**
 * Defines Orientation interface.
 * 
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Position;

use Hjpbarcelos\GdWrapper\Geometry\Point;

/**
 * Abstraction for the positioning of an operation. 
 */
interface Position
{
	/**
	 * Will return the start point of an operation over an image based on these parameters.
	 * 
	 * @param Hjpbarcelos\GdWrapper\Geometry\Point $outsideDimensions The dimensions of the outter image.
	 * @param Hjpbarcelos\GdWrapper\Geometry\Point $insideDimensions The dimensions of the inner image.
	 * 
	 * return \Hjpbarcelos\GdWrapper\Geometry\Point The start point of the operation.
	 */
	public function getStartPoint(Point $outsideDimensions, Point $insideDimensions);
}