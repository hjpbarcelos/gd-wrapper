<?php
/**
 * Defines an end alignment class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Alignment;

use GdWrapper\Geometry\Margin\Margin;

/**
 * Positions the inner segment at the end of the outer segment.
 *
 * Notice that a positive margin will move the inner segment to
 * the left, not to the right as in the other alignments.
 *
 * For example:
 * <code>
 * $align = new End(new Margin\Fixed(10));
 * $align->getPosition(100, 40); // Will return 50 instead of 70.
 * </code>
 *
 * This allows the programmer to change the alignment without worry
 * about in changing the value of the margin.
 */
class End extends AbstractAlignment
{
	/**
	 * Will return the positioning of the inner line segment relative
	 * to the outter line segment.
	 *
	 * {@inherit-doc}
	 * @see GdWrapper\Geometry\Alignment\Alignment::getPosition()
	 */
	public function getPosition($outsideDimention, $insideDimension)
	{
		return round($outsideDimention - $insideDimension)
			- $this->getMarginValue($outsideDimention);
	}
}