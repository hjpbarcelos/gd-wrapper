<?php
/**
 * Defines Margin interface.
 *  
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Margin;

/**
 * Defines an abstraction for a magin distance. 
 * 
 * Notice that margins could be either positives or negatives.
 */
interface Margin
{
	/**
	 * Returns a margin value based on a reference dimension.
	 * 
	 * @param int $refDimension The reference dimension for calculate margin.
	 * 
	 * @return int The margin value.
	 */
	public function getDistance($refDimension);
}