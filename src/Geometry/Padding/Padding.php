<?php
/**
 * Defines Padding interface.
 *  
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Padding;

/**
 * Defines an abstraction for a magin distance. 
 * 
 * Notice that paddings could be either positives or negatives.
 */
interface Padding
{
	/**
	 * Returns a padding value based on a reference dimension.
	 * 
	 * @param int $refDimension The reference dimension for calculate padding.
	 * 
	 * @return int The padding value.
	 */
	public function getDistance($refDimension);
}