<?php
/**
 * Defines Alignment interface.
 *  
 * @author Henrique Barcelos
 */
namespace Hjpbarcelos\GdWrapper\Geometry\Alignment;

/**
 * Defines an abstraction for alignmenting on a line.
 * This is used to alignment things over an image.
 * 
 * This interface implementors do a 1D Alignmenting, that is, given two line segments,
 * they will determine how the inner segment will be Alignmentated relative to the
 * outer segment.
 */
interface Alignment
{
	/**
	 * Obtains the coordinate of the alignment of a segment of length `$insideDimension`
	 * relative to a segment of length `$outsideDimension`.
	 * 
	 * @param int $outsideDimension The length of the outer segment.
	 * @param int $insideDimension The length of the inner segment.
	 * 
	 * @return int
	 */
	public function getPosition($outsideDimension, $insideDimension);
}