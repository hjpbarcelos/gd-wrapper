<?php
/**
 * Defines a center alignment class.
 *
 * @author Henrique Barcelos
 */
namespace GdWrapper\Geometry\Alignment;

use GdWrapper\Geometry\Margin\Margin;

/**
 * Positions the inner segment at the center of the outer segment.
 *
 * A positive margin value will move the alignment to the right.
 *
 * For example:
 * <code>
 * $align = new Center();
 * $align->getPosition(100, 40); // Will return 30
 *
 * $align = new Center(new Margin\Fixed(10));
 * $align->getPosition(100, 40); // Will return 40
 * </code>
 */
class Center extends AbstractAlignment
{
	/**
	 * Will return `0` plus the value of the margin.
	 *
	 * {@inherit-doc}
	 * @see GdWrapper\Geometry\Alignment\Alignment::getPosition()
	 */
	public function getPosition($outsideDimension, $insideDimension)
	{
		return round($outsideDimension/2 - $insideDimension/2)
			+ $this->getMarginValue($outsideDimension);
	}
}